<script setup>
import { getProfileData } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import { onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";

import { deleteUserProfile } from "@/services/user-service";



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


const deleteUser = () => {
    const id = route.params.id;
    loading.value = true
    deleteUserProfile(id).then(res => {
        console.log(res, "res")
        toast.error("Counsellor Deleted Successfully!", {
                autoClose: 6000,
            });
        window.location.href = "/counsellors";
    }).catch(err => {
        console.log(err, "err")
    }).finally(res => {
        loading.value = false
    })
}
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
                    <VForm class="mt-6" >
                        <VRow>
                            <!-- 👉 First Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.name"
                                    label="Name"
                                    readonly="true"
                                    variant="solo"
                                />
                            </VCol>

                            <!-- 👉 Last Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.username"
                                    label="Username"
                                    readonly="true"
                                    variant="solo"
                                />
                            </VCol>

                            <!-- 👉 Email -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.email"
                                    label="E-mail"
                                    type="email"
                                    readonly="true"
                                    variant="solo"
                                />
                            </VCol>

                            <!-- 👉 Phone -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                    readonly="true"
                                    variant="solo"
                                />
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>

        <VCol cols="12" v-if="localUser.data.role_id === 1" >
            <!-- 👉 Deactivate Account -->
            <VCard title="Deactivate Account" :disabled="loading === true">
                <VCardText>
                    <div>
                        <VCheckbox
                            v-model="isAccountDeactivated"
                            label="I confirm my account deactivation"
                        />
                    </div>

                    <VBtn
                        :disabled="!isAccountDeactivated || loading"
                        color="error"
                        class="mt-3"
                        @click="deleteUser"
                    >
                        Deactivate Account
                    </VBtn>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>
