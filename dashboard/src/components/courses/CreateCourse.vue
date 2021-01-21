<template>
    <panel ref="panelRegister" title="Creacion de cursos">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="course-name"
                    >
                        <b-form-input
                            id="course-name"
                            v-model="newCourse.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion"
                        label-cols-md="3"
                        label-for="course-description"
                    >
                        <b-form-textarea
                            id="course-description"
                            type="text"
                            v-model="newCourse.description"
                        ></b-form-textarea>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Precio"
                        label-cols-md="3"
                        label-for="course-price"
                    >
                        <b-form-input
                            id="course-price"
                            v-model="newCourse.price"
                            placeholder="0,0"
                            required
                            type="number"
                            min="0"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Trailer"
                        label-cols-md="3"
                        label-for="course-trailer"
                    >
                        <b-form-input
                            id="course-trailer"
                            v-model="newCourse.trailer"
                            placeholder="Link vimeo"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Imagen"
                        label-cols-md="3"
                        label-for="picture"
                    >
                        <vue-dropzone
                            id="picture"
                            ref="dropzone_picture"
                            :options="dropzoneOptions"
                            @vdropzone-max-files-exceeded="deletePicture"
                            @vdropzone-success="sendSuccess"
                            @vdropzone-error="sendError"
                            @vdropzone-sending="sendingEvent"
                            :useCustomSlot="true"
                        >
                            <div class="dropzone-custom-content">
                                <h3 class="dropzone-custom-title">
                                    Arrastra y suelta para subir contenido!
                                </h3>
                                <div class="subtitle">
                                    ...o da click para seleccionar un arricho de
                                    tu computadora
                                </div>
                            </div>
                        </vue-dropzone>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Categorias"
                        label-cols-md="3"
                        label-for="categories"
                    >
                        <v-select
                            label="name"
                            :options="categories"
                            :placeholder="'Digite nombre de la cagoria'"
                            id="categories"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCategory"
                            @search="searchCategories"
                            :multiple="true"
                        ></v-select>
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
                            <b-button variant="warning" @click="createcourse"
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
            busy: false,
            newCourse: {},
            dropzoneOptions: {
                url: "/api/courses",
                thumbnailWidth: 150,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "photo",
                maxFiles: 1,
            },
            loading: null,
            categories: [],
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.newCourse).forEach((key) => {
                formData.append(key, this.newCourse[key]);
            });
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        createcourse() {
            this.$refs.dropzone_picture.processQueue();
        },
        sendError() {
            this.$swal.fire("Error!", "Registro fallido", "error").then(() => {
                this.resetRegister();
            });
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
        },
        searchCategories(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/categories?query=name|LIKE|%" + value + "%",
                })
                    .then((response) => {
                        loading(false);
                        this.categories = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectCategory(categories) {
            this.newCourse.categories = categories.map((category) => {
                return category.id;
            });
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
