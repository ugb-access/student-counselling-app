<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import { getProfileData } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";

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

const refInputEl = ref();
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
            <VCard title="Student Account Details">
                <VCardText class="d-flex">
                    <!-- 👉 Avatar -->
                    <VAvatar
                        rounded="lg"
                        size="100"
                        class="me-6"
                        :image="accountDataLocal.avatarImg"
                    />

                    <!-- 👉 Upload Photo -->
                </VCardText>

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
                                />
                            </VCol>

                            <!-- 👉 Last Name -->
                            <VCol md="6" cols="12">
                                <VTextField
                                    v-model="accountDataLocal.username"
                                    label="Username"
                                />
                            </VCol>

                            <!-- 👉 Email -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.email"
                                    label="E-mail"
                                    type="email"
                                />
                            </VCol>

                            <!-- 👉 Organization -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                />
                            </VCol>

                            <!-- 👉 Address -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.address"
                                    label="Address"
                                />
                            </VCol>


                           
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>

        <VCol cols="12">
            <!-- 👉 Deactivate Account -->
            <VCard title="Deactivate Account">
                <VCardText>
                    <div>
                        <VCheckbox
                            v-model="isAccountDeactivated"
                            label="I confirm my account deactivation"
                        />
                    </div>

                    <VBtn
                        :disabled="!isAccountDeactivated"
                        color="error"
                        class="mt-3"
                    >
                        Deactivate Account
                    </VBtn>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>
