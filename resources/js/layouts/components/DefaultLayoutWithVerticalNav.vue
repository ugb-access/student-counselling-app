<script setup>
import { useTheme } from "vuetify";
import upgradeBannerDark from "@images/pro/upgrade-banner-dark.png";
import upgradeBannerLight from "@images/pro/upgrade-banner-light.png";
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";
import VerticalNavSectionTitle from "@/@layouts/components/VerticalNavSectionTitle.vue";

// Components
import Footer from "@/layouts/components/Footer.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";
import { getLocalAuth } from "@/utils/local";

const vuetifyTheme = useTheme();

const localUser = JSON.parse(getLocalAuth());
</script>

<template>
    <VerticalNavLayout>
        <!-- 👉 navbar -->
        <template #navbar="{ toggleVerticalOverlayNavActive }">
            <div class="d-flex h-100 align-center">
                <!-- 👉 Vertical nav toggle in overlay mode -->
                <IconBtn
                    class="ms-n3 d-lg-none"
                    @click="toggleVerticalOverlayNavActive(true)"
                >
                    <VIcon icon="mdi-menu" />
                </IconBtn>

                <VSpacer />

                <IconBtn class="me-2">
                    <VIcon icon="mdi-bell-outline" />
                </IconBtn>

                <NavbarThemeSwitcher class="me-2" />

                <UserProfile />
            </div>
        </template>

        <template #vertical-nav-content>
            <VerticalNavLink
                :item="{
                    title: 'Dashboard',
                    icon: 'mdi-home-outline',
                    to: '/dashboard',
                }"
            />
            <VerticalNavLink
                :item="{
                    title: 'Account Settings',
                    icon: 'mdi-account-cog-outline',
                    to: '/account-settings',
                }"
            />

            <!-- 👉 Pages -->
            <VerticalNavSectionTitle
                
                :item="{
                    heading: 'Pages',
                }"
            />
            <VerticalNavLink
                v-if="localUser.data.role_id == 1"
                :item="{
                    title: 'Admins',
                    icon: 'mdi-account-cog',
                    to: '/admins',
                }"
            />
            <VerticalNavLink
                v-if="localUser.data.role_id == 1"
                :item="{
                    title: 'Counsellors',
                    icon: 'mdi-account-tie-outline',
                    to: '/counsellors',
                }"
            />
            <VerticalNavLink
                v-if="
                    localUser.data.role_id == 1 || localUser.data.role_id == 2
                "
                :item="{
                    title: 'Students',
                    icon: 'mdi-account-school',
                    to: '/students',
                }"
            />


            <VerticalNavLink
                v-if="localUser.data.role_id == 3"
                :item="{
                    title: 'Apply Form',
                    icon: 'mdi-file-document-plus-outline',
                    to: '/add-details',
                }"
            />

            <!-- <VerticalNavLink
                :item="{
                    title: 'Register',
                    icon: 'mdi-account-plus-outline',
                    to: '/register',
                }"
            />
            <VerticalNavLink
                :item="{
                    title: 'Error',
                    icon: 'mdi-information-outline',
                    to: '/no-existence',
                }"
            /> -->

            <!-- 👉 User Interface -->
            <!-- <VerticalNavSectionTitle :item="{
        heading: 'User Interface',
      }" />
      <VerticalNavLink :item="{
        title: 'Typography',
        icon: 'mdi-alpha-t-box-outline',
        to: '/typography',
      }" />
      <VerticalNavLink :item="{
        title: 'Icons',
        icon: 'mdi-eye-outline',
        to: '/icons',
      }" />
      <VerticalNavLink :item="{
        title: 'Cards',
        icon: 'mdi-credit-card-outline',
        to: '/cards',
      }" />
      <VerticalNavLink :item="{
        title: 'Tables',
        icon: 'mdi-table',
        to: '/tables',
      }" />
      <VerticalNavLink :item="{
        title: 'Form Layouts',
        icon: 'mdi-form-select',
        to: '/form-layouts',
      }" /> -->
        </template>

        <!-- 👉 Pages -->
        <slot />

        <!-- 👉 Footer
    <template #footer>
      <Footer />
    </template> -->
    </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
    border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
    border-radius: 6px;
    block-size: 1.5625rem;
    line-height: 1.3125rem;
    padding-block: 0.125rem;
    padding-inline: 0.25rem;
}
</style>
