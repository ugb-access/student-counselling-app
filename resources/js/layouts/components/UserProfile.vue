<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import router from "@/router";

import { getLocalAuth, removeLocalAuth } from "@/utils/local";
import { onMounted } from "vue";

const user = ref({
    name: "",
    role_id: 0,
});

const handleLogout = () => {
    removeLocalAuth();

    router.push("/login");
};

onMounted(() => {
    const localUser = JSON.parse(getLocalAuth());
    if (localUser) {
        console.log(localUser.data, "user");
        user.value.name = localUser.data.name;
        user.value.role_id = localUser.data.role_id;
        console.log(user.value.name, "user1");
    }
});
</script>

<template>
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
        <VImg :src="avatar1" />

        <!-- SECTION Menu -->
        <VMenu
            activator="parent"
            width="230"
            location="bottom end"
            offset="14px"
        >
            <VList>
                <!-- 👉 User Avatar & Name -->
                <VListItem>
                    <template #prepend>
                        <VListItemAction start>
                            <VAvatar color="primary" variant="tonal">
                                <VImg :src="avatar1" />
                            </VAvatar>
                        </VListItemAction>
                    </template>

                    <VListItemTitle
                        class="font-weight-semibold text-capitalize"
                    >
                        {{ user?.name || "John Doe" }}
                    </VListItemTitle>
                    <VListItemSubtitle>
                        {{
                            user?.role_id == 2
                                ? "Counsellor"
                                : user?.role_id == 3
                                ? "Student"
                                : "Admin"
                        }}</VListItemSubtitle
                    >
                </VListItem>
                <VDivider class="my-2" />

                <!-- 👉 Profile -->
                <VListItem link to="/account-settings">
                    <template #prepend>
                        <VIcon
                            class="me-2"
                            icon="mdi-account-outline"
                            size="22"
                        />
                    </template>

                    <VListItemTitle>Profile</VListItemTitle>
                </VListItem>

                <!-- 👉 Logout -->
                <VListItem @click="handleLogout">
                    <template #prepend>
                        <VIcon class="me-2" icon="mdi-logout" size="22" />
                    </template>

                    <VListItemTitle>Logout</VListItemTitle>
                </VListItem>
            </VList>
        </VMenu>
        <!-- !SECTION -->
    </VAvatar>
</template>
