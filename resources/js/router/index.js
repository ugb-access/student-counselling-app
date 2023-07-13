import { checkUserAuth } from "@/services/auth-service";
import { removeLocalAuth } from "@/utils/local";
import { createRouter, createWebHistory } from "vue-router";

const authorize = (to, from, next) => {
    const isAuthorized = checkUserAuth(); // Call your authorization check function

    if (isAuthorized) {
        isAuthorized
            .then((res) => {
                if (to.fullPath == "/login" || to.fullPath == "/register") {
                    next("/dashboard");
                } else {
                    // User is authorized, allow navigation to the next route
                    next();
                }
            })
            .catch((err) => {
                removeLocalAuth();
                if (to.fullPath == "/login" || to.fullPath == "/register") {
                    next();
                } else {
                    // User is not authorized, redirect to the login page or any other appropriate route
                    next("/login"); // Replace '/login' with the desired route for unauthorized access
                }
            });
    } else {
        if (to.fullPath == "/login" || to.fullPath == "/register") {
            next();
        } else {
            // User is not authorized, redirect to the login page or any other appropriate route
            next("/login"); // Replace '/login' with the desired route for unauthorized access
        }
    }
};

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            redirect: "/dashboard",
        },
        {
            path: "/",
            component: () => import("../layouts/default.vue"),
            beforeEnter: authorize,
            children: [
                {
                    path: "dashboard",
                    component: () => import("../pages/dashboard.vue"),
                },
                {
                    path: "account-settings",
                    component: () => import("../pages/account-settings.vue"),
                },
                {
                    path: "typography",
                    component: () => import("../pages/typography.vue"),
                },
                {
                    path: "icons",
                    component: () => import("../pages/icons.vue"),
                },
                {
                    path: "cards",
                    component: () => import("../pages/cards.vue"),
                },
                {
                    path: "tables",
                    component: () => import("../pages/tables.vue"),
                },
                {
                    path: "form-layouts",
                    component: () => import("../pages/form-layouts.vue"),
                },
                
                {
                    path: "admins",
                    component: () => import("../pages/admins.vue"),
                },
                
                {
                    path: "students",
                    component: () => import("../pages/students.vue"),
                },

                {
                    path: "counsellors",
                    component: () => import("../pages/counsellors.vue"),
                },

                // Add User

                {
                    path: "add/admin",
                    component: () => import("../pages/add-admin.vue"),
                },

                {
                    path: "add/counsellor",
                    component: () => import("../pages/add-counsellor.vue"),
                },

                {
                    path: "add/student",
                    component: () => import("../pages/add-student.vue"),
                },
            ],
        },
        {
            path: "/",
            component: () => import("../layouts/blank.vue"),
            beforeEnter: authorize,
            children: [
                {
                    path: "login",
                    component: () => import("../pages/login.vue"),
                },
                {
                    path: "register",
                    component: () => import("../pages/register.vue"),
                },
                {
                    path: "/:pathMatch(.*)*",
                    component: () => import("../pages/[...all].vue"),
                },
            ],
        },
    ],
});

export default router;
