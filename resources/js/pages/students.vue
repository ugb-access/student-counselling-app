<script setup>
import PrimaryTable from "@/views/pages/tables/PrimaryTable.vue";
import { getAllStudents } from "@/services/user-service";
import { onMounted, ref, watch } from "vue";
import router from "@/router";

const searchQuery = ref("");
const list = ref([]);
const filteredData = ref([]);

const handleActionClick = () => {
    router.push("/add/student");
};

const fetchData = async () => {
    try {
        const response = await getAllStudents({ limit: null });
        list.value = response.data.data;
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
</script>

<template>
    <VRow>
        <VCol cols="12">
            <VCard title="All Students">
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
