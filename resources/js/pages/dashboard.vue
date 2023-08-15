<script setup>
import AnalyticsAdmin from "@/views/dashboard/AnalyticsAdmin.vue";
import AnalyticsAward from "@/views/dashboard/AnalyticsAward.vue";
import AnalyticsStudentCounsellor from "@/views/dashboard/AnalyticsStudentCounsellor.vue";
import UserAnalytics from "@/views/dashboard/UserAnalytics.vue";

import AnalyticsNotification from "@/views/dashboard/AnalyticsNotification.vue";
import { getLocalAuth } from "@/utils/local";
import { onMounted } from "vue";
import StudentDashboard from "@/views/dashboard/StudentDashboard.vue";

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
            <VCard>
                <VCardItem>
                    <VCardTitle>Overall Users</VCardTitle>
                </VCardItem>

                <VCardText>
                    <h6 class="text-sm font-weight-medium mb-12">
                        <span>Total Growth </span>
                        <span class="font-weight-regular"> this month</span>
                    </h6>
                </VCardText>
            </VCard>
        </VCol>

        <VCol
            cols="12"
            md="8"
            v-if="localUser.data.role_id === 1 || localUser.data.role_id === 2"
        >
            <AnalyticsStudentCounsellor />
        </VCol>

        <VCol cols="12" v-if="localUser.data.role_id === 3">
            <StudentDashboard readonly="true" type="student" />
        </VCol>
    </VRow>
</template>
