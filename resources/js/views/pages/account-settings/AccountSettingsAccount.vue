<script setup>
import { getLocalAuth } from "@/utils/local";
import avatar1 from "@images/avatars/avatar-1.png";
import { getProfileData, updateProfile } from "@/services/user-service";
import { onMounted } from "vue";
import { toast } from "vue3-toastify";

const accountData = {
    avatarImg: avatar1,
    name: "john",
    username: "Doe",
    email: "johnDoe@example.com",
    org: "ThemeSelection",
    phone_number: "+1 (917) 543-9876",
    address: "123 Main St, New York, NY 10001",
    state: "New York",
    zip: "10001",
    country: "USA",
    language: "English",
    timezone: "(GMT-11:00) International Date Line West",
    currency: "USD",
};

const accountDataLocal = ref(structuredClone(accountData));
const edit = ref(false);

const localUser = JSON.parse(getLocalAuth());
const loading = ref(true);

const responseData = ref({
    name: "",
    phone_number: "",
});

const fetchProfileData = () => {
    const id = localUser.data.id;
    getProfileData(id)
        .then((res) => {
            loading.value = false;
            accountDataLocal.value.name = res.data.data.name;
            accountDataLocal.value.username = res.data.data.username;
            accountDataLocal.value.email = res.data.data.email;
            accountDataLocal.value.phone_number = res?.data?.data?.phone_number;
            responseData.value.name = res?.data?.data?.name;
            responseData.value.phone_number = res?.data?.data?.phone_number;
        })
        .catch((err) => {
            console.log(err, "err");
            toast.error(err?.response?.data?.message, {
                autoClose: 6000,
            });
        });
};

const updateProfileData = () => {
    const data = {};
    if (responseData.value?.name?.trim() !== accountDataLocal.value?.name?.trim()) {
        data["name"] = accountDataLocal.value.name.trim();
    }
    if (
        responseData.value?.phone_number?.trim() !== accountDataLocal.value?.phone_number?.trim()
    ) {
        data["phone_number"] = accountDataLocal.value.phone_number.trim();
    }
    if (Object.keys(data).length > 0 && Object.values(data).length > 0) {
        loading.value = true;
        updateProfile(data)
            .then((res) => {
                console.log(res, "res");
            })
            .catch((err) => {
                console.log(err, "err");
            })
            .finally((res) => {
                loading.value = false;
            });
    }
};

onMounted(fetchProfileData);
</script>

<template>
    <VRow>
        <VCol cols="12">
            <VCard
                title="Account Details"
                :loading="loading === true"
                :disabled="loading === true"
            >
                <template v-slot:append>
                    <VBtn
                        color="primary"
                        text
                        @click="
                            () => {
                                edit = true;
                            }
                        "
                        class="action-button"
                        v-if="edit === false && localUser.data.role_id !== 3"
                        >Edit</VBtn
                    >
                </template>

                <VDivider />

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm class="mt-6" @submit.prevent="updateProfileData">
                        <VRow>
                            <!-- 👉 First Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.name"
                                    label="First Name"
                                    :variant="
                                        edit === false ? 'solo' : 'outlined'
                                    "
                                    :readonly="edit === false"
                                />
                            </VCol>

                            <!-- 👉 Last Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.username"
                                    label="Username"
                                    variant="solo"
                                    readonly
                                />
                            </VCol>

                            <!-- 👉 Email -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.email"
                                    label="E-mail"
                                    type="email"
                                    variant="solo"
                                    readonly
                                />
                            </VCol>

                            <!-- 👉 Phone -->
                            <VCol
                                cols="12"
                                md="6"
                                v-if="
                                    localUser.data.role_id === 3 ||
                                    localUser.data.role_id === 2
                                "
                            >
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                    :variant="
                                        edit === false ? 'solo' : 'outlined'
                                    "
                                    :readonly="edit === false"
                                />
                            </VCol>

                            <!-- 👉 Form Actions -->
                            <VCol
                                cols="12"
                                class="d-flex flex-wrap gap-4"
                                v-if="edit === true"
                            >
                                <VBtn type="submit">Save changes</VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>
