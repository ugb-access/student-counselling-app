<script setup>
import { getProfileData } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import { onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";

const accountData = {
    name: "",
    username: "",
    email: "",
    phone_number: "",
};

const accountDataLocal = ref(structuredClone(accountData));

const isAccountDeactivated = ref(false);

const loading = ref(true);
const localUser = JSON.parse(getLocalAuth());

const route = useRoute();

const fetchProfileData = () => {
    const id = route.params.id;
    getProfileData(id)
        .then((res) => {
            loading.value = false;
            accountDataLocal.value.name = res.data.data.name;
            accountDataLocal.value.username = res.data.data.username;
            accountDataLocal.value.email = res.data.data.email;
            accountDataLocal.value.phone_number = res.data.data.phone_number;
        })
        .catch((err) => {
            console.log(err, "Err");
            toast.error(err?.response?.data?.message, {
                autoClose: 6000,
            });
        });
};

onMounted(fetchProfileData);
</script>

<template>
    <VRow>
        <VCol cols="12">
            <VCard
                title="Counsellor Account Details"
                :loading="loading === true"
                :disabled="loading === true"
            >
                <VDivider />

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm class="mt-6">
                        <VRow>
                            <!-- 👉 First Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.name"
                                    label="Name"
                                    readonly="true"
                                />
                            </VCol>

                            <!-- 👉 Last Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.username"
                                    label="Username"
                                    readonly="true"
                                />
                            </VCol>

                            <!-- 👉 Email -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.email"
                                    label="E-mail"
                                    type="email"
                                    readonly="true"
                                />
                            </VCol>

                            <!-- 👉 Phone -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                    readonly="true"
                                />
                            </VCol>

                            <!-- 👉 Form Actions -->
                            <VCol cols="12" class="d-flex flex-wrap gap-4">
                                <VBtn>Save changes</VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>
