<script setup>
import { getProfileData } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import { onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";

import { deleteUserProfile } from "@/services/user-service";

import PrimaryTable from "@/views/pages/tables/PrimaryTable.vue";
import { getAllStudents } from "@/services/user-service";

const searchQuery = ref("");
const list = ref([]);
const filteredData = ref([]);
const page = ref(1);
const length = ref(1);
const from = ref(1);
const total = ref(1);

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
			from.value = res.data.data.from;
			total.value = res.data.data.total;
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
	loading.value = true;
	deleteUserProfile(id)
		.then((res) => {
			console.log(res, "res");
			toast.error("Counsellor Deleted Successfully!", {
				autoClose: 6000,
			});
			window.location.href = "/counsellors";
		})
		.catch((err) => {
			console.log(err, "err");
		})
		.finally((res) => {
			loading.value = false;
		});
};

const fetchData = async () => {
	try {
		const response = await getAllStudents({
			limit: null,
			page: page.value,
			counsellor_id: route.params.id,
			status:
				route.query.status === "all" ? undefined : route.query.status,
		});
		list.value = response.data.data.data;
		length.value = response.data.data.last_page;
		filteredData.value = response.data.data.data;
		from.value = response.data.data.from;
		total.value = response.data.data.total;
	} catch (error) {
		console.error(error);
	}
};

const filterData = async () => {
	try {
		const response = await getAllStudents({
			limit: null,
			search: searchQuery.value,
			counsellor_id: route.params.id,
			status:
				route.query.status === "all" ? undefined : route.query.status,
		});
		list.value = response.data.data.data;
		length.value = response.data.data.last_page;
		filteredData.value = response.data.data.data;
		from.value = response.data.data.from;
	} catch (error) {
		console.error(error);
	}
};

onMounted(fetchData);
watch(searchQuery, filterData);

watch(page, fetchData);
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

		<VCol cols="12" v-if="localUser.data.role_id === 1">
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
		<VCol cols="12">
			<VCard :title="accountDataLocal.name.toUpperCase() + ' Students'">
				<template v-slot:append>
					<div class="d-flex justify-end align-center">
						<VTextField
							v-model="searchQuery"
							label="Search"
							placeholder="Search Students"
							outlined
							class="search-field"
							density="compact"
						></VTextField>
					</div>
				</template>
				<PrimaryTable
					type="student"
					:data="filteredData"
					:from="from"
				/>
				<VPagination v-model="page" :length="length" />
			</VCard>
		</VCol>
		<div class="total-student-count">
			Total Students:
			<span>{{ total }}</span>
		</div>
	</VRow>
</template>

<style scoped>
.search-field {
	width: 300px; /* Adjust the width as needed */
	margin-right: 8px; /* Add margin to separate from the action button */
}
</style>
