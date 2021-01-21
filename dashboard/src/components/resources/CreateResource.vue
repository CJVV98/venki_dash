<template>
    <panel ref="panelRegister" title="Creacion de cursos">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Curso"
                        label-cols-md="3"
                        label-for="courses"
                    >
                        <v-select
                            label="name"
                            :options="courses"
                            :placeholder="'Digite nombre del curso'"
                            id="courses"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCourse"
                            @search="searchCourse"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        v-if="selectedCourse"
                        label="Leccion"
                        label-cols-md="3"
                        label-for="lessons"
                    >
                        <v-select
                            label="name"
                            :options="lessons"
                            :placeholder="'Digite nombre de la leccion'"
                            id="lessons"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectLesson"
                            @search="searchLesson"
                        ></v-select>
                    </b-form-group>
                      <b-form-group
                        class="row"
                        label="Orden"
                        label-cols-md="3"
                        label-for="resource-order"
                    >
                        <b-form-input
                            id="resource-order"
                            v-model="newResource.order"
                            type="number"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Tipo recurso"
                        label-cols-md="3"
                        label-for="resource-type"
                    >
                        <v-select
                            id="resource-type"
                            :options="['audio', 'video', 'document']"
                            :value="selectedType"
                            @input="selectType"
                            :clearable="false"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Recurso"
                        label-cols-md="3"
                        label-for="resource"
                        v-if="selectedType != 'video'"
                    >
                        <vue-dropzone
                            id="resource"
                            ref="dropzone_picture"
                            :options="dropzoneOptions"
                            @vdropzone-max-files-exceeded="deleteResource"
                            @vdropzone-success="sendSuccess"
                            @vdropzone-error="sendError"
                            @vdropzone-sending="sendingEvent"
                            :useCustomSlot="true"
                            :key="keyDrop"
                        >
                            <div class="dropzone-custom-content">
                                <h3 class="dropzone-custom-title">
                                    Arrastra y suelta para subir contenido!
                                </h3>
                                <div class="subtitle">
                                    ...o da click para seleccionar un archivo de
                                    tu computadora
                                </div>
                            </div>
                        </vue-dropzone>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Video"
                        label-cols-md="3"
                        v-if="selectedType == 'video'"
                        label-for="resource-video"
                    >
                        <b-form-input
                            id="resource-video"
                            v-model="newResource.video"
                            placeholder="Link vimeo"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4" offset-md="6">
                    <b-row>
                        <b-col col sm="6" md="4" offset-md="0">
                            <b-button
                                variant="outline-primary"
                                @click="resetRegister"
                                >Limpiar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="createResource"
                                >Registrar</b-button
                            >
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </panel>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
let searchTimer = null;
export default {
    data() {
        return {
            newResource: {},
            loading: null,
            courses: [],
            lessons: [],
            selectedCourse: null,
            keyDrop: 0,
            selectedType: "audio",
            dropzoneOptions: {
                url: "/api/resources",
                thumbnailWidth: 150,
                addRemoveLinks: true,
                autoProcessQueue: false,
                acceptedFiles: "audio/*",
                paramName: "audio",
                maxFiles: 1,
            },
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        selectType(type) {
            this.selectedType = type;
            if (type == "audio") {
                this.dropzoneOptions.acceptedFiles = "audio/*";
            } else if (type == "document") {
                this.dropzoneOptions.acceptedFiles = ".doc,.docx,.pdf";
            }
            this.dropzoneOptions.paramName = type;
            delete this.newResource.video;
            this.resetDropzone();
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
        },
        searchCourse(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/courses?query=name|LIKE|%" + value + "%",
                })
                    .then((response) => {
                        loading(false);
                        this.courses = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectCourse(course) {
            this.selectedCourse = course.id;
        },
        searchLesson(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url:
                        "/api/courses/" +
                        this.selectedCourse +
                        "/lessons?query=name|LIKE|%" +
                        value +
                        "%",
                })
                    .then((response) => {
                        loading(false);
                        this.lessons = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectLesson(lesson) {
            this.newResource.lesson_id = lesson.id;
        },
        deleteResource(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        createResource() {
            if (this.selectedType == "video") {
                this.$http({
                    method: "POST",
                    url: "/api/resources",
                    data: this.newResource,
                })
                    .then(() => {
                        this.$swal.fire("Exito", "Recurso creado", "success");
                        this.registrationSuccessful();
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$swal.fire(
                            "Error",
                            "Error creando recurso",
                            "error"
                        );
                    });
            } else {
                this.$refs.dropzone_picture.processQueue();
            }
        },
        sendError() {
            this.$swal.fire("Error!", "Registro fallido", "error").then(() => {
                this.resetRegister();
            });
        },
        sendingEvent(file, xhr, formData) {
            Object.keys(this.newResource).forEach((key) => {
                formData.append(key, this.newResource[key]);
            });
        },
        resetDropzone() {
            this.keyDrop++;
        },
    },
};
</script>

<style scoped>
.dropzone-custom-content {
    position: inherit;
    top: 50%;
    left: 50%;
    text-align: center;
}

.dropzone-custom-title {
    margin-top: 0;
    color: #00b782;
}

.subtitle {
    color: #314b5f;
    font-size: medium;
}
</style>
