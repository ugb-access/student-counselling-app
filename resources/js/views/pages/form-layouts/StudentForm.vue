<script setup>

import router from "@/router";
import { addCounsellor, addStudent } from "@/services/user-service";
import { toast } from "vue3-toastify";

const name = ref("");
const username = ref("");
const password = ref("");
const email = ref("");
const phone_number = ref("");


const isPasswordVisible = ref(false);

const handleSubmit = () => {
    const emailV = email.value;
    const passwordV = password.value;
    const nameV = name.value;
    const usernameV = username.value;
    const phone_numberV = phone_number.value;

    if (
        !emailV.trim() ||
        !passwordV.trim() ||
        !nameV.trim() ||
        !usernameV.trim() ||
        !phone_numberV.trim()
    ) {
        return "Field is required";
    }

    addStudent({
        username: usernameV,
        name: nameV,
        password: passwordV,
        email: emailV,
        phone_number: phone_numberV,
    })
        .then((res) => {
            router.push("/students");
            toast.success(res.data.message, {
                autoClose: 6000,
            });
            
        })
        .catch((err) => {
            console.log(
                err?.response?.data?.error,
                "err?.response?.data?.error"
            );
            if (err?.response?.data?.error) {
                toast.error(err.response.data.error, {
                    autoClose: 6000,
                });
            }
        });
};


const required = (value) => {
    if (!value?.trim()) {
        return "Field is required";
    }
};

const passwordValidation = (value) => {
    if (value?.trim() && value?.trim().length < 6) {
        return "Password cannot be less than 6 characters";
    }

    if (value?.trim() && value?.trim().length > 8) {
        return "Password cannot be greater than 8 characters";
    }
};

const emailValidation = (value) => {
    const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    if (!emailRegex.test(value)) {
        return "Please Enter Correct Email";
    }
};
const usernameValidation = (value) => {
    const usernameRegex = /^[a-zA-Z0-9_-]{3,16}$/;
    if (!usernameRegex.test(value)) {
        return "Please Enter Correct Username";
    }
};

const phoneValidation = (value) => {
    const phoneRegex = /^[0-9]+$/;
    if (!phoneRegex.test(value)) {
        return "Only Numbers are allowed in phone";
    }
};
</script>

<template>
    <VForm @submit.prevent="handleSubmit">
        <VRow>
            <!-- 👉 Name -->
            <VCol>
                <VTextField
                    v-model="name"
                    label="Name"
                    placeholder="Name"
                    :rules="[required]"
                />
            </VCol>

            <!-- 👉 User Name -->
            <VCol>
                <VTextField
                    v-model="username"
                    label="Username"
                    placeholder="Username"
                    :rules="[required, usernameValidation]"
                />
            </VCol>
        </VRow>
        <VRow>
            <VCol>
                <VTextField
                    v-model="email"
                    type="email"
                    label="Email"
                    placeholder="Email"
                    :rules="[required, emailValidation]"
                />
            </VCol>

            <VCol>
                <VTextField
                    v-model="phone_number"
                    label="Phone Number"
                    placeholder="Phone Number"
                    :rules="[required, phoneValidation]"
                />
            </VCol>

            <!-- Password -->
            <VCol>
                <VTextField
                    v-model="password"
                    label="Password"
                    placeholder="Password"
                    :type="isPasswordVisible ? 'text' : 'password'"
                    :append-inner-icon="
                        isPasswordVisible
                            ? 'mdi-eye-off-outline'
                            : 'mdi-eye-outline'
                    "
                    @click:append-inner="isPasswordVisible = !isPasswordVisible"
                    :rules="[required, passwordValidation]"
                />
            </VCol>
        </VRow>
        <!-- 👉 Email -->
        <VRow>
            <VCol cols="12" class="d-flex gap-4">
                <VBtn type="submit"> Submit </VBtn>

                <VBtn type="reset" color="secondary" variant="tonal">
                    Reset
                </VBtn>
            </VCol>
        </VRow>
    </VForm>
</template>
