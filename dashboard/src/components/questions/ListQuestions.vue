<template>
    <div>
        <Panel ref="panelList" title="Tabla de cursos">
            <b-container>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            class="row"
                            label="Perfil"
                            label-cols-md="3"
                            label-for="profiles-list"
                        >
                            <v-select
                                label="name"
                                :options="profiles"
                                :placeholder="'Digite nombre del perfl'"
                                id="profiles-list"
                                :clear-search-on-select="false"
                                :filterable="false"
                                @input="selectProfile"
                                @search="seachProfile"
                            ></v-select>
                        </b-form-group>
                    </b-col>
                </b-row>
                <div class="table-responsive" v-if="selectedProfile">
                    <vue-good-table
                        mode="remote"
                        :rows="questions"
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
            questions: [],
            columns: [
                {
                    label: "ID",
                    field: "id",
                },
                {
                    label: "Pregunta",
                    field: "question",
                },
                {
                    label: "Categoria",
                    field: "category.name",
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
            profiles: [],
            selectedProfile: null,
        };
    },
    methods: {
        confirmDelete(question_id) {
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
                        url: "/api/questions/" + question_id,
                    })
                        .then(() => {
                            loader.hide();
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.questions = this.questions.filter(
                                    (question) => {
                                        return question.id !== question_id;
                                    }
                                );
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
        selectQuestion(question) {
            this.$emit("selectQuestion", question);
        },
        loadQuestions() {
            if (this.selectedProfile) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url: "/api/profiles/" + this.selectedProfile + "/questions",
                    params: {
                        per_page: this.perPage,
                        page: this.page,
                    },
                })
                    .then((response) => {
                        this.questions = response.data.data;
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
            this.loadQuestions();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadQuestions();
        },
        seachProfile(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/profiles",
                    params: {
                        ...(value
                            ? {
                                  query: "name|like|" + value,
                              }
                            : null),
                    },
                })
                    .then((response) => {
                        loading(false);
                        this.profiles = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectProfile(profile) {
            this.selectedProfile = profile.id;
            this.loadQuestions();
        },
    },
    created() {
        if (this.selectedProfile) {
            this.loadQuestions();
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
