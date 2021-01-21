<template>
    <Panel title="Lista de respuestas">
        <div class="table-responsive">
            <vue-good-table
                mode="remote"
                :rows="replies"
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
                        <div class="text-center">
                            <a
                                class="btn btn-primary"
                                @click="selectReply(props.row.id)"
                            >
                                <i class="fas fa-eye fa-fw"></i>
                            </a>
                            <a
                                class="btn btn-danger"
                                @click="confirmDelete(props.row.id)"
                            >
                                <i class="fas fa-trash-alt fa-fw"></i>
                            </a>
                        </div>
                    </span>
                    <span v-else-if="props.column.field == 'created_at'">{{
                        props.row.created_at | formatMoment
                    }}</span>
                    <span v-else>{{
                        props.formattedRow[props.column.field]
                    }}</span>
                </template>
            </vue-good-table>
        </div>
    </Panel>
</template>

<script>
export default {
    data() {
        return {
            replies: [],
            page: 1,
            perPage: 10,
            totalRecords: 0,
            columns: [
                {
                    label: "ID",
                    field: "id",
                },
                {
                    label: "Usuario",
                    field: "user.email",
                },
                {
                    label: "Creacion",
                    field: "created_at",
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
    mounted() {
        this.loadReplies();
    },
    methods: {
        loadReplies() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url: "/api/replies",
                params: {
                    per_page: this.perPage,
                    page: this.page,
                    query: "scored|=|false",
                },
            })
                .then((response) => {
                    loader.hide();
                    this.replies = response.data.data;
                    this.totalRecords = response.data.meta.total;
                })
                .catch((error) => {
                    loader.hide();
                    console.log(error);
                    this.$swal.fire("Error", "Error en el servidor", "error");
                });
        },
        onPageChange(params) {
            this.page = params.currentPage;
            this.loadReplies();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadReplies();
        },
        selectReply(reply_id) {
            this.$emit("selectReply", reply_id);
        },
    },
    filters: {
        formatMoment(value) {
            /*global moment*/
            /*eslint no-undef: "error"*/
            return moment(value).fromNow();
        },
    },
};
</script>

<style></style>
