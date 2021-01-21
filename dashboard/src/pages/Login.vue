<template>
    <!-- begin login -->
    <div class="login login-v1">
        <!-- begin login-container -->
        <div class="login-container">
            <!-- begin login-header -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span>
                    <b>Color</b> Administrador
                   
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-body -->
            <div class="login-body">
                <!-- begin login-content -->
                <div class="login-content">
                    <div class="form-group m-b-20">
                        <input
                            type="text"
                            class="form-control form-control-lg inverse-mode"
                            placeholder="Email Address"
                            required
                        />
                    </div>
                    <div class="form-group m-b-20">
                        <input
                            type="password"
                            class="form-control form-control-lg inverse-mode"
                            placeholder="Password"
                            required
                        />
                    </div>
                    <div class="checkbox checkbox-css m-b-20">
                        <input type="checkbox" id="remember_checkbox" />
                        <label for="remember_checkbox">Remember Me</label>
                    </div>
                    <div class="login-buttons">
                        <button
                            type="button"
                            @click="checkForm"
                            class="btn btn-success btn-block btn-lg"
                        >
                            Iniciar sesion
                        </button>
                    </div>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end login-body -->
        </div>
        <!-- end login-container -->
    </div>
    <!-- end login -->
</template>

<script>
import PageOptions from "../config/PageOptions.vue";

export default {
    created() {
        PageOptions.pageEmpty = true;
    },
    beforeRouteLeave() {
        PageOptions.pageEmpty = false;
        window.location = "/home";
    },
    methods: {
        checkForm: function () {
            this.$http({
                method: "POST",
                url: "/api/oauth/token",
                data: {
                    username: "ricardo1@dominio.com",
                    password: "12345678",
                    client_secret: "lDcTfL8zFExFDQWf3I7ppk4PWuFTR81d0o8YVPeT",
                    client_id: "920a627b-13a9-4dbb-8af1-e269807f1a74",
                    grant_type: "password",
                },
            })
                .then(() => {
                    this.$router.replace("/home");
                })
                .catch((error) => {
                    console.trace(error);
                });
        },
    },
};
</script>
