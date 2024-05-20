<script setup>
import PrimaryTable from "@/views/pages/tables/PrimaryTable.vue";
import { getAllAdmins, getAllCounsellor } from "@/services/user-service";
import { onMounted, ref, watch } from "vue";
import router from "@/router";

const searchQuery = ref("");
const list = ref([]);
const filteredData = ref([]);

const from = ref(1);

const handleActionClick = () => {
	window.location.href = "/add/admin";
};

const fetchData = async () => {
	try {
		const response = await getAllAdmins({ limit: null });
		list.value = response.data.data;

		from.value = response.data.data.from;
		filterData();
	} catch (error) {
		console.error(error);
	}
};

const filterData = () => {
	filteredData.value = list.value.filter((counsellor) => {
		return (
			counsellor.name
				.toLowerCase()
				.includes(searchQuery.value.toLowerCase()) ||
			counsellor.username
				.toLowerCase()
				.includes(searchQuery.value.toLowerCase()) ||
			counsellor.email
				.toLowerCase()
				.includes(searchQuery.value.toLowerCase()) ||
			counsellor.created_at
				.slice(0, counsellor.created_at.indexOf("T"))
				.toLowerCase()
				.includes(searchQuery.value.toLowerCase())
		);
	});
};

onMounted(fetchData);
watch(searchQuery, filterData);
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard title="All Admins">
				<template v-slot:append>
					<div class="d-flex justify-end align-center">
						<VTextField
							v-model="searchQuery"
							label="Search"
							placeholder="Search Admins"
							outlined
							class="search-field"
							density="compact"
						></VTextField>
						<VBtn
							color="primary"
							text
							@click="handleActionClick"
							class="action-button"
							>Add Admin</VBtn
						>
					</div>
				</template>
				<PrimaryTable
					:data="filteredData"
					table-type="admin"
					:from="from"
				/>
			</VCard>
		</VCol>
	</VRow>
</template>

<style scoped>
.search-field {
	width: 300px; /* Adjust the width as needed */
	margin-right: 8px; /* Add margin to separate from the action button */
}
</style>
