<template>
    <div>
        <Panel title="Detalles Respuesta">
            <div class="profile-content">
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4>
                                        {{ reply.user.name }}
                                        <small>{{ reply.user.lastname }}</small>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="divider highlight">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Teléfono</td>
                                <td>{{ reply.user.phone }}</td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Correo</td>
                                <td>
                                    <i class="fa fa-mobile fa-lg m-r-5"></i>
                                    {{ reply.user.email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Nacimiento</td>
                                <td>{{ reply.user.birthday }}</td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Perfil</td>
                                <td>
                                    {{ reply.survey.profile.name }}
                                </td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Resultados</td>
                                <td>
                                    <tr
                                        v-for="(average,
                                        key,
                                        index) in reply.reply"
                                        :key="index"
                                    >
                                        <td>
                                            {{ key }}
                                        </td>
                                        <td>
                                            <span class="label label-info"
                                                >{{ average }}
                                            </span>
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Cursos</td>
                                <td>
                                    <tr
                                        v-for="(course, index) in reply.user
                                            .courses"
                                        :key="index"
                                    >
                                        <td>{{ course.name }}</td>
                                        <td>
                                            <span
                                                class="label label-lg"
                                                :class="
                                                    course.pivot.complete !=
                                                    false
                                                        ? 'label-success'
                                                        : 'label-warning'
                                                "
                                                >{{
                                                    course.pivot.complete ==
                                                    false
                                                        ? "Incompleto"
                                                        : "Completo"
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Curso nuevo</td>
                                <td>
                                    <b-row>
                                        <b-col md="5">
                                            <v-select
                                                label="name"
                                                :options="courses"
                                                :placeholder="'Digite nombre del curso'"
                                                :clear-search-on-select="false"
                                                :filterable="false"
                                                @input="selectCourse"
                                                @search="searchCourse"
                                            ></v-select>
                                        </b-col>
                                        <b-col md="4">
                                            <button
                                                @click="assingCourse"
                                                class="btn btn-info btn-white-without-border width-150"
                                            >
                                                Registrar
                                            </button>
                                        </b-col>
                                    </b-row>
                                </td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">&nbsp;</td>
                                <td class="p-t-10 p-b-10">
                                    <button
                                        @click="closeCase(reply.id)"
                                        class="btn btn-primary width-150"
                                    >
                                        Cerrar caso
                                    </button>
                                    <button
                                        @click="resetView"
                                        class="btn btn-white btn-white-without-border width-150 m-l-5"
                                    >
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </Panel>
    </div>
</template>

<script>
let searchTimer = null;
export default {
    props: {
        initialReply: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            reply: { ...this.initialReply },
            selectedCourse: null,
            courses: [],
        };
    },
    methods: {
        resetView() {
            this.$emit("reset-view");
        },
        closeCase(reply_id) {
            this.$swal({
                title: "Está seguro?",
                text: "Estos cambios no podran ser revertidos",
                icon: "warning",
                showCancelButton: true,
            }).then((response) => {
                if (response.value) {
                    let loader = this.$loading.show();
                    this.$http({
                        method: "PUT",
                        url: "/api/replies/" + reply_id,
                        data: { scored: true },
                    })
                        .then(() => {
                            loader.hide();
                            this.$emit("case-closed");
                            this.$swal.fire(
                                "Hecho!",
                                "Caso cerrado",
                                "success"
                            );
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$swal.fire(
                                "Error!",
                                "Error cerrando caso",
                                "error"
                            );
                        });
                }
            });
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
        assingCourse() {
            if (this.selectedCourse) {
                let loader = this.$loading.show();
                this.$http({
                    method: "POST",
                    url: "/api/users/" + this.reply.user.id + "/courses",
                    data: { course_id: this.selectedCourse },
                })
                    .then(() => {
                        this.$swal.fire("Hecho", "Curso asignado", "success");
                        loader.hide();
                        this.loadReply();
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$swal.fire("Error", "Error actualizando", "error");
                    });
            } else {
                this.$swal.fire("Error", "Seleccione curso", "error");
            }
        },
        loadReply() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url: "/api/replies/" + this.reply.id,
            })
                .then((response) => {
                    this.reply = response.data.data;
                    loader.hide();
                })
                .catch((error) => {
                    console.log(error);
                    loader.hide();
                });
        },
    },
};
</script>

<style></style>
