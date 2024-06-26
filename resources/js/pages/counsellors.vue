<script setup>
import PrimaryTable from "@/views/pages/tables/PrimaryTable.vue";
import { getAllCounsellor } from "@/services/user-service";
import { onMounted, ref, watch } from "vue";
import router from "@/router";

const searchQuery = ref("");
const list = ref([]);
const filteredData = ref([]);
const page = ref(1);
const length = ref(1);

const from = ref(1);

const handleActionClick = () => {
	window.location.href = "/add/counsellor";
};

const fetchData = async () => {
	try {
		const response = await getAllCounsellor({
			limit: null,
			page: page.value,
		});
		list.value = response.data.data.data;
		length.value = response.data.data.last_page;

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

watch(page, fetchData);
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard title="All Counsellors">
				<template v-slot:append>
					<div class="d-flex justify-end align-center">
						<VTextField
							v-model="searchQuery"
							label="Search"
							placeholder="Search Counsellors"
							outlined
							class="search-field"
							density="compact"
						></VTextField>
						<VBtn
							color="primary"
							text
							@click="handleActionClick"
							class="action-button"
							>Add Counsellor</VBtn
						>
					</div>
				</template>
				<PrimaryTable
					table-type="counsellor"
					:data="filteredData"
					:from="from"
				/>
				<VPagination v-model="page" :length="length" />
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
