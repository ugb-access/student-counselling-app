<script setup>
import router from "@/router";
import { getAllCounsellor } from "@/services/user-service";
import { addStudent } from "@/services/user-service";
import { watch } from "vue";
import { getLocalAuth } from "@/utils/local";

import { onMounted } from "vue";
import { toast } from "vue3-toastify";

const name = ref("");
const username = ref("");
const password = ref("");
const email = ref("");
const phone_number = ref("");
const counsellor = ref(null);
const counsellors = ref([]);
const search_keyword = ref("");
const counsellor_ids = ref([]);
const loading = ref(false);
const submitLoading = ref(false);

const isPasswordVisible = ref(false);
const localUser = JSON.parse(getLocalAuth());

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
    if (localUser.data.role_id == 1 && !counsellor.value) {
        toast.error("Counsellor is required", {
            autoClose: 6000,
        });
        return;
    }
    submitLoading.value = true;
 
    addStudent({
        username: usernameV,
        name: nameV,
        password: passwordV,
        email: emailV,
        phone_number: phone_numberV,
        counsellor_id:
            localUser.data.role_id == 1
                ? counsellor_ids.value.find(
                      (item) => item?.username === counsellor?.value
                  )?.id
                : undefined,
    })
        .then((res) => {
            toast.success(res.data.message, {
                autoClose: 6000,
            });
            window.location.href = "/students";
        })
        .catch((err) => {
            if (err?.response?.data?.error) {
                toast.error(err.response.data.error, {
                    autoClose: 6000,
                });
            }
            submitLoading.value = false;
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

    if (value?.trim() && value?.trim().length > 10) {
        return "Password cannot be greater than 10 characters";
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

const getCounsellors = async (value) => {
   
    loading.value = true;
    const response = await getAllCounsellor({
        search: value,
        limit: 5,
    });
    counsellors.value = response.data.data.map((item) => item.username);
    counsellor_ids.value = response.data.data;

    loading.value = false;
};

onMounted(getCounsellors);

watch(search_keyword, (val) => {
    if (val && val !== counsellor.value) {
        getCounsellors(val);
    }
});
</script>

<template>
    <VForm :disabled="submitLoading" @submit.prevent="handleSubmit">
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
            <VCol>
                <VTextField
                    v-model="email"
                    type="email"
                    label="Email"
                    placeholder="Email"
                    :rules="[required, emailValidation]"
                />
            </VCol>
        </VRow>
        <VRow>
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
            <VCol v-if="localUser.data.role_id == 1">
                <v-autocomplete
                    v-model="counsellor"
                    v-model:search="search_keyword"
                    :loading="loading"
                    :items="counsellors"
                    hide-no-data
                    hide-details
                    label="Select Counsellor"
                    :rules="[required]"
                ></v-autocomplete
            ></VCol>
        </VRow>
        <!-- 👉 Email -->
        <VRow>
            <VCol cols="12" class="d-flex gap-4">
                <VBtn type="submit" :disabled="submitLoading"> Submit </VBtn>

                <VBtn
                    type="reset"
                    :disabled="submitLoading"
                    color="secondary"
                    variant="tonal"
                >
                    Reset
                </VBtn>
            </VCol>
        </VRow>
    </VForm>
</template>
