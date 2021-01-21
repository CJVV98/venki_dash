<script>
const routes = [
    {
        path: "/",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Login.vue").then(
                (Login) => {
                    resolve(Login.default);
                }
            ),
    },
    {
        path: "/home",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Home.vue").then(
                (Home) => {
                    resolve(Home.default);
                }
            ),
    },
    {
        path: "/categories",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Category.vue").then(
                (Category) => {
                    resolve(Category.default);
                }
            ),
    },
    {
        path: "/profiles",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Profile.vue").then(
                (Profile) => {
                    resolve(Profile.default);
                }
            ),
    },
    {
        path: "/courses",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Course.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
    },
    {
        path: "/lessons",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Lesson.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
    },
    {
        path: "/resource",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Resource.vue").then(
                (Resource) => {
                    resolve(Resource.default);
                }
            ),
    },
    {
        path: "/surveys",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Survey.vue").then(
                (Survey) => {
                    resolve(Survey.default);
                }
            ),
    },
    {
        path: "/questions",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Question.vue").then(
                (Question) => {
                    resolve(Question.default);
                }
            ),
    },
    {
        path: "/replies",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Reply.vue").then(
                (Reply) => {
                    resolve(Reply.default);
                }
            ),
    },
    {
        path: "/users",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Users.vue").then(
                (Users) => {
                    resolve(Users.default);
                }
            ),
    },
     {
        path: "/images",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Image.vue").then(
                (Image) => {
                    resolve(Image.default);
                }
            ),
    },
];

export default routes;
</script>
