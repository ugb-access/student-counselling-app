<script setup>
import { useTheme } from "vuetify";
import logo from "@images/logo.svg?raw";
import authV1MaskDark from "@images/pages/auth-v1-mask-dark.png";
import authV1MaskLight from "@images/pages/auth-v1-mask-light.png";
import authV1Tree2 from "@images/pages/auth-v1-tree-2.png";
import authV1Tree from "@images/pages/auth-v1-tree.png";
import { loginUser } from "@/services/auth-service";
import { toast } from "vue3-toastify";

const form = ref({
    email: "",
    password: "",
});

const vuetifyTheme = useTheme();

const authThemeMask = computed(() => {
    return vuetifyTheme.global.name.value === "light"
        ? authV1MaskLight
        : authV1MaskDark;
});

const isPasswordVisible = ref(false);

const isFieldRequired = (value) => {
    if (!value.trim()) return "Field is required";
};

const passwordValidation = (value) => {
    if (value.trim() && value.trim().length < 6) {
        return "Password cannot be less than 6 characters";
    }

    if (value.trim() && value.trim().length > 10) {
        return "Password cannot be greater than 10 characters";
    }
};

const handleSubmit = (e) => {
    const { email, password } = form.value;
    if (!email.trim() || !password.trim()) return "Field is required";
    if (password.trim() && password.trim().length < 6) {
        return "Password cannot be less than 6 characters";
    }

    if (password.trim() && password.trim().length > 10) {
        return "Password cannot be greater than 10 characters";
    }
    loginUser({ identifier: email.trim(), password: password.trim() })
        .then((res) => {
            localStorage.setItem("auth_data", {
                token: res.data.token,
                data: res.data.data,
            });
            toast.success(res.data.message, {
                autoClose: 6000,
            });
        })
        .catch((err) => {
            if (err.response.data.error) {
                toast.error(err.response.data.error, {
                    autoClose: 6000,
                });
            }
        });
};
</script>

<template>
    <div class="auth-wrapper d-flex align-center justify-center pa-4">
        <VCard class="auth-card pa-4 pt-7" max-width="448">
            <VCardItem class="justify-center">
                <template #prepend>
                    <div class="d-flex">
                        <div v-html="logo" />
                    </div>
                </template>

                <VCardTitle
                    class="font-weight-semibold text-2xl text-uppercase"
                >
                    Materio
                </VCardTitle>
            </VCardItem>

            <VCardText class="pt-2">
                <h5 class="text-h5 font-weight-semibold mb-1">
                    Welcome to Materio! 👋🏻
                </h5>
                <p class="mb-0">
                    Please sign-in to your account and start the adventure
                </p>
            </VCardText>

            <VCardText>
                <VForm @submit.prevent="handleSubmit">
                    <VRow>
                        <!-- email -->
                        <VCol cols="12">
                            <VTextField
                                v-model="form.email"
                                label="Email/Username"
                                type="email"
                                :rules="[isFieldRequired]"
                            />
                        </VCol>

                        <!-- password -->
                        <VCol cols="12">
                            <VTextField
                                v-model="form.password"
                                label="Password"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="
                                    isPasswordVisible
                                        ? 'mdi-eye-off-outline'
                                        : 'mdi-eye-outline'
                                "
                                @click:append-inner="
                                    isPasswordVisible = !isPasswordVisible
                                "
                                :rules="[isFieldRequired, passwordValidation]"
                            />

                            <!-- remember me checkbox -->
                            <div
                                class="d-flex align-center justify-end flex-wrap mt-1 mb-4"
                            >
                                <a class="ms-2 mb-1" href="javascript:void(0)">
                                    Forgot Password?
                                </a>
                            </div>

                            <!-- login button -->
                            <VBtn block type="submit"> Login </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>

        <VImg
            class="auth-footer-start-tree d-none d-md-block"
            :src="authV1Tree"
            :width="250"
        />

        <VImg
            :src="authV1Tree2"
            class="auth-footer-end-tree d-none d-md-block"
            :width="350"
        />

        <!-- bg img -->
        <VImg class="auth-footer-mask d-none d-md-block" :src="authThemeMask" />
    </div>
</template>

<style lang="scss">
@use "@core-scss/pages/page-auth.scss";
</style>
