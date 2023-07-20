<script setup>
import AnalyticsAdmin from "@/views/dashboard/AnalyticsAdmin.vue";
import AnalyticsAward from "@/views/dashboard/AnalyticsAward.vue";
import AnalyticsStudentCounsellor from "@/views/dashboard/AnalyticsStudentCounsellor.vue";
import UserAnalytics from "@/views/dashboard/UserAnalytics.vue";

import AnalyticsNotification from "@/views/dashboard/AnalyticsNotification.vue";
import { getLocalAuth } from "@/utils/local";

const localUser = JSON.parse(getLocalAuth());
</script>

<template>
    <VRow class="match-height">
        <VCol
            cols="12"
            md="8"
            v-if="localUser.data.role_id === 1 || localUser.data.role_id === 2"
        >
            <UserAnalytics />
        </VCol>
        <VCol cols="12" md="4">
            <AnalyticsNotification />
        </VCol>

        <VCol cols="12" md="4" v-if="localUser.data.role_id === 1">
            <AnalyticsAdmin />
        </VCol>

        <VCol
            cols="12"
            md="8"
            v-if="localUser.data.role_id === 1 || localUser.data.role_id === 2"
        >
            <AnalyticsStudentCounsellor />
        </VCol>
    </VRow>
</template>
