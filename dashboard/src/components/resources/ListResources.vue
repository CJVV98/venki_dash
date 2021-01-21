<template>
    <div>
        <Panel ref="panelList" title="Tabla de recursos">
            <b-container>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            class="row"
                            label="Cursos"
                            label-cols-md="3"
                            label-for="list-courses"
                        >
                            <v-select
                                label="name"
                                :options="courses"
                                :placeholder="'Digite nombre del curso'"
                                id="list-courses"
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
                            label-for="list-lessons"
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
                    </b-col>
                </b-row>
                <div class="table-responsive" v-if="selectedLesson">
                    <vue-good-table
                        mode="remote"
                        :rows="resources"
                        :columns="columns"
                        :sort-options="sort"
                        :pagination-options="pagination_options"
                        :totalRows="totalRecords"
                        @on-page-change="onPageChange"
                        @on-per-page-change="onPerPageChange"
                        styleClass="table table-bordered m-b-0"
                    >
                        <div slot="emptystate">
                            No hay informacion disponible
                        </div>
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'resource'">
                                <span v-if="props.row.document">
                                    <a
                                        :href="'/' + props.row.document"
                                        target="_blank"
                                        >Link documento</a
                                    >
                                </span>
                                <span v-else-if="props.row.audio">
                                    <a
                                        :href="'/' + props.row.audio"
                                        target="_blank"
                                        >Link Audio</a
                                    >
                                </span>
                                <span v-else-if="props.row.video">
                                    <a :href="props.row.video" target="_blank"
                                        >Link Vimeo</a
                                    >
                                </span>
                            </span>
                            <span v-if="props.column.field == 'actions'">
                                <span>
                                    <div class="text-center">
                                        <a
                                            class="btn btn-danger"
                                            @click="confirmDelete(props.row.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt fa-fw"
                                            ></i>
                                        </a>
                                    </div>
                                </span>
                            </span>
                            <span v-else>{{
                                props.formattedRow[props.column.field]
                            }}</span>
                        </template>
                    </vue-good-table>
                </div>
            </b-container>
        </Panel>
    </div>
</template>

<script>
let searchTimer = null;
export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            columns: [
                {
                    label: "ID",
                    field: "id",
                },
                {
                    label: "Recurso",
                    field: "resource",
                },
                {
                    label: "Orden",
                    field: "order",
                },
                {
                    label: "Acciones",
                    field: "actions",
                },
            ],
            sort: {
                enabled: false,
            },
            pagination_options: {
                enabled: true,
                mode: "pages",
                nextLabel: "Sig",
                prevLabel: "Ant",
                rowsPerPageLabel: "Registros por pagina",
                ofLabel: "de",
                pageLabel: "Pagina", // for 'pages' mode
                allLabel: "Todos",
                perPageDropdown: [10, 30, 50],
                dropdownAllowAll: false,
            },
            courses: [],
            resources: [],
            lessons: [],
            selectedCourse: null,
            selectedLesson: null,
        };
    },
    methods: {
        confirmDelete(resource_id) {
            this.$swal({
                title: "Está seguro?",
                text: "Estos cambios no podran ser revertidos",
                icon: "warning",
                showCancelButton: true,
            }).then((response) => {
                if (response.value) {
                    let loader = this.$loading.show();
                    this.$http({
                        method: "DELETE",
                        url: "/api/resources/" + resource_id,
                    })
                        .then(() => {
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.loadLessons();
                                loader.hide();
                            });
                        })
                        .catch((error) => {
                            this.$swal({
                                title: "Error!",
                                icon: "error",
                                text: error.data.error,
                            }).then(() => {
                                loader.hide();
                            });
                        });
                }
            });
        },
        loadResources() {
            if (this.selectedLesson) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url:
                        "/api/lessons/" +
                        this.selectedLesson +
                        "/resources?per_page=" +
                        this.perPage +
                        "&page=" +
                        this.page,
                })
                    .then((response) => {
                        this.resources = response.data.data;
                        this.totalRecords = response.data.meta.total;
                        loader.hide();
                    })
                    .catch(() => {
                        loader.hide();
                        this.$swal({
                            title: "Error",
                            text: "Error cargando los datos",
                            icon: "error",
                        });
                    });
            }
        },
        onPageChange(params) {
            this.page = params.currentPage;
            this.loadLessons();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadLessons();
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
            this.selectedLesson = lesson.id;
            this.loadResources();
        },
    },
    created() {
        if (this.selectedLesson) {
            this.loadResources();
        }
    },
};
</script>

<style scoped>
.img-category {
    max-height: 100px;
    max-width: 150px;
    height: auto;
    width: auto;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.img-category:hover {
    opacity: 0.7;
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0, 0, 0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    margin-top: 10%;
}

/* Add Animation - Zoom in the Modal */
.modal-content,
#caption {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {
        transform: scale(0);
    }
    to {
        transform: scale(1);
    }
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px) {
    .modal-content {
        width: 100%;
    }
}
</style>
