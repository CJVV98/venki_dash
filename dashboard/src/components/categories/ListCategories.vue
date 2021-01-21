<template>
    <div>
        <Panel ref="panelList" title="Tabla de categorias">
            <b-container>
                <div class="table-responsive">
                    <vue-good-table
                        mode="remote"
                        :rows="categories"
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
                                            class="btn btn-grey"
                                            @click="selectCategory(props.row)"
                                        >
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
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
                            <span v-else-if="props.column.field == 'photo'">
                                <div
                                    class="text-center"
                                    @click="selectPhoto(props.row.photo)"
                                >
                                    <img
                                        class="img-category"
                                        loading="lazy"
                                        :src="'/' + props.row.photo"
                                    />
                                </div>
                            </span>
                            <span v-else>{{
                                props.formattedRow[props.column.field]
                            }}</span>
                        </template>
                    </vue-good-table>
                </div>
            </b-container>
        </Panel>
        <div
            id="modal-foto"
            :style="{ display: isOpen }"
            class="modal"
            @click="closeModalImage"
        >
            <!-- Modal Content (The Image) -->
            <img
                class="modal-content"
                loading="lazy"
                :src="'/' + selectedPhoto"
                id="image"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            categories: [],
            columns: [
                {
                    label: "ID",
                    field: "id",
                },
                {
                    label: "Nombre",
                    field: "name",
                },
                {
                    label: "Descripcion",
                    field: "description",
                },
                {
                    label: "Foto",
                    field: "photo",
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
            selectedPhoto: null,
            isOpen: "none",
        };
    },
    methods: {
        confirmDelete(category_id) {
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
                        url: "/api/categories/" + category_id,
                    })
                        .then(() => {
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.loadCategories();
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
        selectCategory(category) {
            this.$emit("selectCategory", category);
        },
        selectPhoto(photo) {
            this.selectedPhoto = photo;
            this.isOpen = "block";
        },
        closeModalImage() {
            this.isOpen = "none";
        },
        loadCategories() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url:
                    "/api/categories?per_page=" +
                    this.perPage +
                    "&page=" +
                    this.page,
            })
                .then((response) => {
                    this.categories = response.data.data;
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
        },
        onPageChange(params) {
            this.page = params.currentPage;
            this.loadCategories();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadCategories();
        },
    },
    created() {
        this.loadCategories();
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
