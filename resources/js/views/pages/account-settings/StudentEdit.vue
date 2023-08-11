<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import { watch } from "vue";
import { updateUserProfile } from "@/services/user-service";

const accountData = {
    name: "",
    username: "",
    email: "",
    phone_number: "",
};

const accountDataLocal = ref(structuredClone(accountData));
const props = defineProps({
    data: Object,
});

const { data } = toRefs(props);

const loading = ref(true);

const route = useRoute();

const responseData = ref({
    name: "",
    phone_number: "",
});

const fetchProfileData = () => {
    
    loading.value = false;
    accountDataLocal.value.name = data.value.name;
    accountDataLocal.value.username = data.value.username;
    accountDataLocal.value.email = data.value.email;
    accountDataLocal.value.phone_number = data.value.phone_number;
    responseData.value.name = data?.value?.name;
    responseData.value.phone_number = data?.value?.phone_number;
};

watch(data, fetchProfileData);

const updateStudentProfile = () => {
    const id = route.params.id;

    const data = {};
   
    if (
        responseData.value?.name?.trim() !==
        accountDataLocal.value?.name?.trim()
    ) {
        data["name"] = accountDataLocal.value.name.trim();
    }
    if (
        responseData.value?.phone_number?.trim() !==
        accountDataLocal.value?.phone_number?.trim()
    ) {
        data["phone_number"] = accountDataLocal.value.phone_number.trim();
    }

    if (Object.keys(data).length > 0 && Object.values(data).length > 0) {
        loading.value = true;
        updateUserProfile(id, data)
            .then((res) => {
                
                window.location.href = `/student/view/${id}`;
            })
            .catch((err) => {
                console.log(err, "err");
            })
            .finally((res) => {
                loading.value = false;
            });
    }
};
</script>

<template>
    <VRow>
        <VCol cols="12">
            <VCard
                title="Student Account Details"
                :loading="loading === true"
                :disabled="loading === true"
            >
                <VDivider />

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm @submit.prevent="updateStudentProfile" class="mt-6">
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
                                    readonly
                                    variant="solo"
                                />
                            </VCol>

                            <!-- 👉 Email -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.email"
                                    label="E-mail"
                                    type="email"
                                    readonly
                                    variant="solo"
                                />
                            </VCol>

                            <!-- 👉 Organization -->
                            <VCol cols="12" md="6">
                                <VTextField
                                    v-model="accountDataLocal.phone_number"
                                    label="Phone Number"
                                />
                            </VCol>

                            <!-- 👉 Form Actions -->
                            <VCol cols="12" class="d-flex flex-wrap gap-4">
                                <VBtn type="submit" :disabled="loading"
                                    >Save changes</VBtn
                                >
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>
