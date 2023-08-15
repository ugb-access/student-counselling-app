<script setup>
import { getLocalAuth } from "@/utils/local";
import avatar1 from "@images/avatars/avatar-1.png";
import { watch } from "vue";
import { deleteUserProfile } from "@/services/user-service";
import { useRoute } from "vue-router";
const route = useRoute();

const accountData = {
    avatarImg: avatar1,
    name: "",
    username: "",
    email: "",
    org: "",
    phone_number: "",
    address: "",
    state: "",
    zip: "",
    country: "",
    language: "",
    timezone: "",
    currency: "",
};
const accountDataLocal = ref(structuredClone(accountData));
const isAccountDeactivated = ref(false);

const props = defineProps({
    data: Object,
});

const { data } = toRefs(props);

const loading = ref(true);

const fetchProfileData = () => {
    loading.value = false;
    accountDataLocal.value.name = data.value.name;
    accountDataLocal.value.username = data.value.username;
    accountDataLocal.value.email = data.value.email;
    accountDataLocal.value.phone_number = data.value.phone_number;
};

watch(data, fetchProfileData);

const localUser = JSON.parse(getLocalAuth());

const deleteUser = () => {
    const id = route.params.id;
    loading.value = true;
    deleteUserProfile(id)
        .then((res) => {
            toast.error("Student Deleted Successfully!", {
                autoClose: 6000,
            });
            window.location.href = "/students";
        })
        .catch((err) => {
            console.log(err, "err");
        })
        .finally((res) => {
            loading.value = false;
        });
};

const handleWhatsapp = () => {
    console.log("Clicked");
    window.open(`https://wa.me/${data.value.phone_number}`, "_blank");
};
</script>

<template>
    <VRow>
        <VCol cols="12">
            <VCard
                :loading="loading"
                :disabled="loading"
                title="Student Account Details"
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

                            <!-- 👉 Organization -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                    readonly="true"
                                    variant="solo"
                                    @click:append-inner="handleWhatsapp"
                                >
                                    <template v-slot:append-inner>
                                        <VButton @click="handleWhatsapp">
                                            <VIcon
                                                class="cursor-pointer"
                                                color="#00a884"
                                                icon="mdi-whatsapp"
                                                size="large"
                                            >
                                            </VIcon>
                                        </VButton>
                                    </template>
                                </VTextField>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>

        <VCol cols="12" v-if="localUser.data.role_id === 1">
            <!-- 👉 Deactivate Account -->
            <VCard title="Deactivate Account" :disabled="loading">
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
