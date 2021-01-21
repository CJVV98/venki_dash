<template>
    <div>
        <Panel ref="panelList" title="Tabla de perfiles">
            <b-container>
                <div class="table-responsive">
                    <vue-good-table
                        mode="remote"
                        :rows="profiles"
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
export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            profiles: [],
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
        };
    },
    methods: {
        confirmDelete(profile_id) {
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
                        url: "/api/profiles/" + profile_id,
                    })
                        .then(() => {
                            loader.hide();
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.loadProfiles();
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
        selectProfile(profile) {
            this.$emit("selectProfile", profile);
        },
        loadProfiles() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url: "/api/profiles",
                params: {
                    per_page: this.perPage,
                    page: this.page,
                },
            })
                .then((response) => {
                    this.profiles = response.data.data;
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
            this.loadProfiles();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadProfiles();
        },
    },
    created() {
        this.loadProfiles();
    },
};
</script>
