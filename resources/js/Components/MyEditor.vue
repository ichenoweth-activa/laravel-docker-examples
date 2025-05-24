<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import Image from "@tiptap/extension-image";
import { VBtn } from "vuetify/components";
import { ref } from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);

const editor = useEditor({
    editorProps: {
        attributes: {
            class: "",
            style: "height: 200px; overflow-y: auto",
        },
    },
    content: props.modelValue,
    onUpdate: ({ editor }) => {
        //console.log(editor.getHTML())
        emit("update:modelValue", editor.getHTML());
    },
    extensions: [
        StarterKit,
        Underline,
        Image.configure({
            inline: true,
            allowBase64: true,
        }),
    ],
});

const convertBase64 = (file) => {
    return new Promise((resolve, reject) => {
        // eslint-disable-next-line
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.onload = () => {
            resolve(fileReader.result);
        };

        fileReader.onerror = (error) => {
            reject(error);
        };
    });
};
const subirArchivoDialog = ref(false);

const onFileSelected = async (event) => {
    const file = event.target.files[0];
    if (file) {
        const base64 = await convertBase64(file);
        editor.value.chain().focus().setImage({ src: base64 }).run();
        subirArchivoDialog.value = false;
        // form.userFile = file;
        // form.size = formatFileSize(file.size);
    }
};

const cancelUpload = () => {
    // form.reset();
    subirArchivoDialog.value = false;
};
</script>

<template>
    <div>
        <v-toolbar>
            <v-btn-toggle v-if="editor" variant="outlined">
                <v-btn
                    icon="mdi-format-bold"
                    @click="editor.chain().focus().toggleBold().run()"
                    :disabled="!editor.can().chain().focus().toggleBold().run()"
                    :class="{ 'is-active': editor.isActive('bold') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-italic"
                    @click="editor.chain().focus().toggleItalic().run()"
                    :disabled="
                        !editor.can().chain().focus().toggleItalic().run()
                    "
                    :class="{ 'is-active': editor.isActive('italic') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-underline"
                    @click="editor.chain().focus().setUnderline().run()"
                    :disabled="editor.isActive('underline')"
                >
                </v-btn>

                <v-btn
                    icon="mdi-check-underline"
                    @click="editor.chain().focus().unsetUnderline().run()"
                    :disabled="!editor.isActive('underline')"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-strikethrough"
                    @click="editor.chain().focus().toggleStrike().run()"
                    :disabled="
                        !editor.can().chain().focus().toggleStrike().run()
                    "
                    :class="{ 'is-active': editor.isActive('strike') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-clear"
                    @click="editor.chain().focus().unsetAllMarks().run()"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-header-1"
                    @click="
                        editor.chain().focus().toggleHeading({ level: 1 }).run()
                    "
                    :class="{
                        'is-active': editor.isActive('heading', { level: 1 }),
                    }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-header-2"
                    @click="
                        editor.chain().focus().toggleHeading({ level: 2 }).run()
                    "
                    :class="{
                        'is-active': editor.isActive('heading', { level: 2 }),
                    }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-header-3"
                    @click="
                        editor.chain().focus().toggleHeading({ level: 3 }).run()
                    "
                    :class="{
                        'is-active': editor.isActive('heading', { level: 3 }),
                    }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-format-list-bulleted"
                    @click="editor.chain().focus().toggleBulletList().run()"
                    :class="{ 'is-active': editor.isActive('bulletList') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-order-numeric-ascending"
                    @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="{ 'is-active': editor.isActive('orderedList') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-comment-quote-outline"
                    @click="editor.chain().focus().toggleBlockquote().run()"
                    :class="{ 'is-active': editor.isActive('blockquote') }"
                >
                </v-btn>

                <v-btn
                    icon="mdi-line-scan"
                    @click="editor.chain().focus().setHorizontalRule().run()"
                >
                </v-btn>

                <v-btn
                    icon="mdi-slash-forward-box"
                    @click="editor.chain().focus().setHardBreak().run()"
                >
                </v-btn>

                <v-btn
                    icon="mdi-undo"
                    @click="editor.chain().focus().undo().run()"
                    :disabled="!editor.can().chain().focus().undo().run()"
                >
                </v-btn>

                <v-btn
                    icon="mdi-redo"
                    @click="editor.chain().focus().redo().run()"
                    :disabled="!editor.can().chain().focus().redo().run()"
                >
                </v-btn>

                <v-btn
                    icon="mdi-image"
                    @click="subirArchivoDialog = !subirArchivoDialog"
                >
                </v-btn>
            </v-btn-toggle>
        </v-toolbar>
        <editor-content :editor="editor" />
    </div>
    <v-dialog v-model="subirArchivoDialog" persistent width="1024">
        <v-card>
            <v-card-title>
                <span class="text-h5">Agregar imagen</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-file-input
                        @change="onFileSelected"
                        clearable
                        label="Subir imagen"
                        variant="solo-inverted"
                        prepend-icon="mdi-camera"
                        accept="image/png, image/jpeg, image/bmp"
                    ></v-file-input>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="cancelUpload"
                >
                    Cancelar
                </v-btn>
                <v-btn
                    :disabled="!isFileSelected"
                    @click="uploadFile()"
                    append-icon="mdi-cloud-upload-outline"
                    color="secondary"
                    variant="elevated"
                >
                    Subir Archivo
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
:deep(.tiptap) {
    :first-child {
        margin-top: 0;
    }
    width: auto;
    height: 200px !important;
    img {
        max-width: 100%;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1em;

        &.ProseMirror-selectednode {
            outline: 3px solid #68cef8;
        }
    }
}
:deep(.tiptap img) {
    max-width: 100%;
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-top: 1em;
}
:deep(.ProseMirror-selectednode) {
    outline: 3px solid #68cef8;
}
</style>
