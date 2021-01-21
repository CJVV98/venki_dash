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
                        label="Nombre"
                        label-cols-md="3"
                        label-for="lesson-name"
                    >
                        <b-form-input
                            id="lesson-name"
                            v-model="newLesson.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion"
                        label-cols-md="3"
                        label-for="lesson-description"
                    >
                        <b-form-textarea
                            id="lesson-description"
                            type="text"
                            v-model="newLesson.description"
                        ></b-form-textarea>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Duracion"
                        label-cols-md="3"
                        label-for="lesson-duration"
                    >
                        <b-form-input
                            id="lesson-duration"
                            v-model="newLesson.duration"
                            placeholder="Duracion en días"
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
                            <b-button variant="warning" @click="createLesson"
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
let searchTimer = null;
export default {
    data() {
        return {
            newLesson: {},
            loading: null,
            courses: [],
        };
    },
    methods: {
        createLesson() {
            let loader = this.$loading.show();
            this.$http({
                method: "POST",
                url: "/api/lessons",
                data: this.newLesson,
            })
                .then(() => {
                    this.registrationSuccessful();
                    loader.hide();
                    this.$swal.fire("Exito!", "Registro exitoso", "success");
                })
                .catch((error) => {
                    console.log(error);
                    loader.hide();
                    this.$swal
                        .fire("Error!", "Error durante el registro", "error")
                        .then(() => {
                            this.resetRegister();
                        });
                });
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
            this.newLesson.course_id = course.id;
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
