<script setup>
import { useRoute } from "vue-router";
import StudentEdit from "@/views/pages/account-settings/StudentEdit.vue";
import AddStudentDetails from "@/views/pages/form-layouts/AddStudentDetails.vue";

const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
    {
        title: "Account",
        icon: "mdi-account-outline",
        tab: "account",
    },

    {
        title: "Student Detail",
        icon: "mdi-account-outline",
        tab: "student-detail",
    },
];
</script>

<template>
    <div>
        <VTabs v-model="activeTab" show-arrows>
            <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
                <VIcon size="20" start :icon="item.icon" />
                {{ item.title }}
            </VTab>
        </VTabs>
        <VDivider />

        <VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
            <!-- Account -->
            <VWindowItem value="account">
                <StudentEdit />
            </VWindowItem>

            <VWindowItem value="student-detail">
                <AddStudentDetails />
            </VWindowItem>
        </VWindow>
    </div>
</template>
