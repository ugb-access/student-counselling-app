<script setup>
import PrimaryTable from "@/views/pages/tables/PrimaryTable.vue";
import { getAllStudents } from "@/services/user-service";
import { onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";

const searchQuery = ref("");
const list = ref([]);
const filteredData = ref([]);
const page = ref(1);
const length = ref(1);
const route = useRoute();

const handleActionClick = () => {
    window.location.href = "/add/student";
};

const fetchData = async () => {
    try {
        const response = await getAllStudents({
            limit: null,
            page: page.value,
            status:
                route.query.status === "all" ? undefined : route.query.status,
        });
        list.value = response.data.data.data;
        length.value = response.data.data.last_page;
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
                .includes(searchQuery.value.toLowerCase()) ||
            counsellor.phone_number
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
            <VCard title="All Students">
                <template v-slot:append>
                    <div class="d-flex justify-end align-center">
                        <div>
                            <VBtn
                                href="/students?status=all"
                                size="small"
                                :color="
                                    route.query.status === 'all' ||
                                    !route.query?.status
                                        ? 'primary'
                                        : 'grey-900'
                                "
                                text
                                class="action-button mx-2"
                                variant="plain"
                                >All</VBtn
                            >
                            <VBtn
                                href="/students?status=incomplete"
                                size="small"
                                :color="
                                    route.query.status === 'incomplete'
                                        ? 'primary'
                                        : 'grey-900'
                                "
                                text
                                class="action-button"
                                variant="plain"
                                >Incomplete</VBtn
                            >
                            <VBtn
                                href="/students?status=complete"
                                size="small"
                                :color="
                                    route.query.status === 'complete'
                                        ? 'primary'
                                        : 'grey-900'
                                "
                                text
                                class="action-button mx-2"
                                variant="plain"
                                >Complete</VBtn
                            >

                            <VBtn
                                href="/students?status=paid"
                                size="small"
                                :color="
                                    route.query.status === 'paid'
                                        ? 'primary'
                                        : 'grey-900'
                                "
                                text
                                class="action-button mx-2"
                                variant="plain"
                                >Paid</VBtn
                            >
                        </div>
                        <VTextField
                            v-model="searchQuery"
                            label="Search"
                            placeholder="Search Students"
                            outlined
                            class="search-field"
                            density="compact"
                        ></VTextField>
                        <VBtn
                            color="primary"
                            text
                            @click="handleActionClick"
                            class="action-button"
                            >Add Student</VBtn
                        >
                    </div>
                </template>
                <PrimaryTable type="student" :data="filteredData" />
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
