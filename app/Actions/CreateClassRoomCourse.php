<?php

namespace App\Actions;

use App\Models\Google\Console\User;
use Google_Service_Classroom_CourseWorkMaterial;

class CreateClassRoomCourse
{
    public function execute($courseIdClassroom, $cursoName, $description, $category, $instructorEmails)
    {
        $googleConsoleUser = User::first();
        $googleConsoleEmail = $googleConsoleUser->email;
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);
        $newCourse = new \Google_Service_Classroom_Course(
            [
                'name' => $cursoName,
                'section' => $category,
                'description' => $description,
                'room' => '301',
                'ownerId' => $googleConsoleEmail,
                'courseState' => 'ACTIVE',
            ]
        );
        $newCourse = $classroom->courses->create($newCourse);
        $courseIdOrigen = $courseIdClassroom;
        $courseIdDestino = $newCourse->id;
        $pageTokenCourseWork = null;
        $pageTokenTopics = null;
        $pageTokenAnnouncements = null;
        $courseWork = []; //todas las tareas
        $announcements = [];

        //todas las topicos
        $topics = [];
        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenTopics,
            ];

            $results = $classroom->courses_topics->listCoursesTopics($courseIdOrigen, $optParams);
            $topics = array_merge($topics, $results->getTopic());
            $pageTokenTopics = $results->nextPageToken;
        } while (! empty($pageTokenTopics));
        //Storage::append('topicos.json', json_encode($topics));

        //todas las tareas
        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenCourseWork,
                'courseWorkStates' => ['DRAFT', 'PUBLISHED'],
            ];
            $results = $classroom->courses_courseWork->listCoursesCourseWork($courseIdOrigen, $optParams);
            $courseWork = array_merge($courseWork, $results->getCourseWork());
            $pageTokenCourseWork = $results->nextPageToken;
        } while (! empty($pageTokenCourseWork));

        //OBTENER LOS MATERIALES DEL CURSO
        $pageTokenCourseWork = null;
        $courseWorkMaterials = [];
        $materials = collect();
        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenCourseWork,
                //'courseWorkStates' => ['DRAFT', 'PUBLISHED']
            ];
            $results = $classroom->courses_courseWorkMaterials->listCoursesCourseWorkMaterials($courseIdOrigen, $optParams);
            $courseWorkMaterials = array_merge($courseWorkMaterials, $results->getCourseWorkMaterial());
            $pageTokenCourseWork = $results->nextPageToken;

        } while (! empty($pageTokenCourseWork));

        foreach ($courseWorkMaterials as $courseWorkMaterial) {
            $materials->add([
                'courseId' => $courseWorkMaterial['courseId'],
                'title' => $courseWorkMaterial['title'],
                'topicId' => $courseWorkMaterial['topicId'],
                'materials' => $courseWorkMaterial['materials'],
                'state' => $courseWorkMaterial['state'],
                'assigneeMode' => $courseWorkMaterial['assigneeMode'],
                'description' => $courseWorkMaterial['description'],
            ]);
        }
        //FIN DE OBTENER LOS MATERIALES DEL CURSO.
        $materialesByTopicId = $materials->where('topicId', '=', null);

        foreach ($materialesByTopicId as $materialId) {
            $totalMateriales = collect();
            foreach ($materialId['materials'] as $materialIndividual) {
                if ($materialIndividual->getLink() || $materialIndividual->getDriveFile()
                    || $materialIndividual->getYoutubeVideo()) {
                    $totalMateriales->add($materialIndividual);
                }
            }
            $courseWorkMaterial = new Google_Service_Classroom_CourseWorkMaterial([
                'title' => $materialId['title'],
                'description' => $materialId['description'],
                //'state' => 'PUBLISHED',
                'materials' => $totalMateriales->all(),
            ]);
            $classroom
                ->courses_courseWorkMaterials
                ->create($courseIdDestino, $courseWorkMaterial);
        }

        $topicosNuevos = collect();

        foreach ($topics as $topic) {
            $newTopic = new \Google_Service_Classroom_Topic([
                'name' => $topic['name'],
            ]);
            $newTopic = $classroom->courses_topics->create($courseIdDestino, $newTopic);
            $topicosNuevos->add(['topic_id' => $topic['topicId'], 'new_id' => $newTopic->getTopicId()]);
            $materialesByTopicId = $materials->where('topicId', '=', $topic['topicId']);

            // Storage::append('materialesByTopicId.json', json_encode($materialesByTopicId));

            foreach ($materialesByTopicId as $materialId) {
                $totalMateriales = collect();
                foreach ($materialId['materials'] as $materialIndividual) {
                    if ($materialIndividual->getLink() || $materialIndividual->getDriveFile()
                        || $materialIndividual->getYoutubeVideo()) {
                        $totalMateriales->add($materialIndividual);
                    }
                }
                $courseWorkMaterial = new Google_Service_Classroom_CourseWorkMaterial([
                    'title' => $materialId['title'],
                    'description' => $materialId['description'],
                    //'state' => 'PUBLISHED',
                    'materials' => $totalMateriales->all(),
                    'topicId' => $newTopic->getTopicId(),
                ]);
                $classroom
                    ->courses_courseWorkMaterials
                    ->create($courseIdDestino, $courseWorkMaterial);
            }
        }

        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenAnnouncements,
            ];
            $results = $classroom->
            courses_announcements->
            listCoursesAnnouncements($courseIdOrigen, $optParams);
            if (count($results) > 0) {
                $announcements = array_merge($announcements, $results->getAnnouncements());
            }
            $pageTokenAnnouncements = $results->nextPageToken;
        } while (! empty($pageTokenAnnouncements));

        foreach ($announcements as $anuncio) {
            $nuevo_anuncio = [
                'text' => $anuncio['text'],
                //'materials' => $anuncio['materials'],
                'state' => 'PUBLISHED',
                'scheduledTime' => $anuncio['scheduledTime'],
                'assigneeMode' => 'ALL_STUDENTS',
            ];

            $newAnnouncement = new \Google_Service_Classroom_Announcement($nuevo_anuncio);
            $classroom->courses_announcements->create($newCourse->getId(), $newAnnouncement);
        }

        foreach ($courseWork as $trabajo) {
            $workType = $trabajo['workType'];
            $cursoAux = [
                'state' => 'DRAFT',
                'assigneeMode' => 'ALL_STUDENTS',
                'workType' => $workType,
            ];
            $topico = $topicosNuevos->firstWhere('topic_id', $trabajo['topicId']);
            if ($topico) {
                $cursoAux = array_merge($cursoAux, ['topicId' => $topico['new_id']]);
            }
            if ($trabajo['title']) {
                $cursoAux = array_merge($cursoAux, ['title' => $trabajo['title']]);
            }
            if ($trabajo['description']) {
                $cursoAux = array_merge($cursoAux, ['description' => $trabajo['description']]);
            }
            if ($trabajo['maxPoints']) {
                $cursoAux = array_merge($cursoAux, ['maxPoints' => $trabajo['maxPoints']]);
            }
            if ($trabajo['scheduledTime']) {
                $cursoAux = array_merge($cursoAux, ['scheduledTime' => $trabajo['scheduledTime']]);
            }
            if ($workType === 'MULTIPLE_CHOICE_QUESTION') {
                $multiple = [];
                foreach ($trabajo['multipleChoiceQuestion']['choices'] as $choice) {
                    $multiple[] = $choice;
                }
                $multipleChoiceQuestion = new \Google_Service_Classroom_MultipleChoiceQuestion(['choices' => $multiple]);
                $cursoAux = array_merge($cursoAux, ['multipleChoiceQuestion' => $multipleChoiceQuestion]);
            }

            $newTrabajo = new \Google_Service_Classroom_CourseWork($cursoAux);

            try {
                $classroom->courses_courseWork->create($courseIdDestino, $newTrabajo);
            } catch (\Exception) {

            }
        }

        /***teacher bloque****/
        foreach ($instructorEmails as $email) {

                try {
                    $classroom->courses_teachers->get($newCourse->id, $email);
                } catch (\Exception $e) {
                    //excepcion controlada, sino fue encontrado el docente en el curso, crearlo
                    //no quitar el me
                    $teacher = new \Google_Service_Classroom_Teacher([
                        'userId' => $email,
                    ]);
                    $classroom->courses_teachers->create($newCourse->id, $teacher);
                }

        }

        // return $newCourse->id;
        $classroomUrl = $newCourse->getAlternateLink();

        return ['id' => $newCourse->id, 'url' => $classroomUrl];

    }
}
