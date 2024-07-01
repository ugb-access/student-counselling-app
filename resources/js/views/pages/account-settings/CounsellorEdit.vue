<script setup>
import { getProfileData } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import { onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";
import { updateUserProfile } from "@/services/user-service";

const accountData = {
	name: "",
	username: "",
	email: "",
	phone_number: "",
};
const localUser = JSON.parse(getLocalAuth());

const accountDataLocal = ref(structuredClone(accountData));

const loading = ref(true);

const route = useRoute();

const responseData = ref({
	name: "",
	phone_number: "",
	username: "",
	email: "",
});
const fetchProfileData = () => {
	const id = route.params.id;
	getProfileData(id)
		.then((res) => {
			console.log(res, "res");
			loading.value = false;
			accountDataLocal.value.name = res.data.data.name;
			accountDataLocal.value.username = res.data.data.username;
			accountDataLocal.value.email = res.data.data.email;
			accountDataLocal.value.phone_number = res.data.data.phone_number;

			responseData.value.name = res?.data?.data?.name;
			responseData.value.phone_number = res?.data?.data?.phone_number;
			responseData.value.username = res?.data?.data?.username;
			responseData.value.email = res?.data?.data?.email;
		})
		.catch((err) => {
			console.log(err, "Err");
			toast.error(err?.response?.data?.message, {
				autoClose: 6000,
			});
		});
};

const updateCounsellorProfile = () => {
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

	if (
		responseData.value?.username?.trim() !==
		accountDataLocal.value?.username?.trim()
	) {
		data["username"] = accountDataLocal.value.username.trim();
	}
	if (
		responseData.value?.email?.trim() !==
		accountDataLocal.value?.email?.trim()
	) {
		data["email"] = accountDataLocal.value.email.trim();
	}

	if (Object.keys(data).length > 0 && Object.values(data).length > 0) {
		loading.value = true;
		updateUserProfile(id, data)
			.then((res) => {
				console.log(res, "res");
				window.location.href = `/counsellors/view/${id}`;
			})
			.catch((err) => {
				console.log(err, "err");
                toast.error(err?.response?.data?.error, {
				autoClose: 6000,
			});
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
				title="Counsellor Account Details"
				:loading="loading === true"
				:disabled="loading === true"
			>
				<VDivider />

				<VCardText>
					<!-- 👉 Form -->
					<VForm
						class="mt-6"
						@submit.prevent="updateCounsellorProfile"
					>
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
									:variant="
										localUser.data.role_id !== 1
											? 'solo'
											: 'outlined'
									"
									:readonly="
										localUser.data.role_id !== 1
											? true
											: false
									"
								/>
							</VCol>

							<!-- 👉 Email -->
							<VCol cols="12" md="6">
								<VTextField
									v-model="accountDataLocal.email"
									label="E-mail"
									type="email"
									:variant="
										localUser.data.role_id !== 1
											? 'solo'
											: 'outlined'
									"
									:readonly="
										localUser.data.role_id !== 1
											? true
											: false
									"
								/>
							</VCol>

							<!-- 👉 Phone -->
							<VCol cols="12" md="6">
								<VTextField
									v-model="accountDataLocal.phone_number"
									label="Phone Number"
								/>
							</VCol>

							<!-- 👉 Form Actions -->
							<VCol cols="12" class="d-flex flex-wrap gap-4">
								<VBtn :disabled="loading" type="submit"
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
