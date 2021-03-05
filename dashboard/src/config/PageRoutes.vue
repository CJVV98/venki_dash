
<script>

const routes = [
    {
        path: "/",
        name: "login",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Login.vue").then(
                (Login) => {
                    resolve(Login.default);
                }
            ),
    },
    {
        path: "/home",
        name: "home",
        component: (resolve) =>
           import(/* webpackChunkName: "pages" */ "@/pages/Home.vue").then(
                (Home) => {
                    resolve(Home.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/categories",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Category.vue").then(
                (Category) => {
                    resolve(Category.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/profiles",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Profile.vue").then(
                (Profile) => {
                    resolve(Profile.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/courses",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Course.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/lessons",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Lesson.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/resource",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Resource.vue").then(
                (Resource) => {
                    resolve(Resource.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/surveys",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Survey.vue").then(
                (Survey) => {
                    resolve(Survey.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/questions",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Question.vue").then(
                (Question) => {
                    resolve(Question.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/replies",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Reply.vue").then(
                (Reply) => {
                    resolve(Reply.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/users",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Users.vue").then(
                (Users) => {
                    resolve(Users.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
     {
        path: "/images",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Image.vue").then(
                (Image) => {
                    resolve(Image.default);
                }
            ),
         meta: {
             requiresAuth: true,
         }
    },
    {
        path: "/activities",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Activity.vue").then(
                (Activity) => {
                    resolve(Activity.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    }
];

export default routes;
</script>
