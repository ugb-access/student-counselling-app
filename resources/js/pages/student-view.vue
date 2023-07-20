<script setup>
import { useRoute } from "vue-router";
import StudentDetail from "@/views/pages/account-settings/StudentDetail.vue";

const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
    {
        title: "Account",
        icon: "mdi-account-outline",
        tab: "account",
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
                <StudentDetail />
            </VWindowItem>
        </VWindow>
    </div>
</template>
