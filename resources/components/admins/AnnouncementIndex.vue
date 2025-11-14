<template>
    <div class="w-full overflow-auto">
        <div class="pb-20 rounded-md items-center lg:mx-10">
            <div class="bg-blue-900 w-full lg:px-10">
                <h1
                    class="text-center text-white uppercase font-mono font-extrabold rounded-md"
                >
                    Welcome
                </h1>
            </div>

            <div
                v-for="user_info in user"
                :key="user_info.id"
                class="text-center"
            >
                <div class="flex text-center justify-left my-2">
                    <UserIcon class="h-8 w-8 mr-2" />
                    <h5
                        class="my-auto bg-emerald-300 text-slate-700 px-5 py-2 rounded-lg"
                    >
                        {{ user_info.name }}
                    </h5>
                </div>

                <div
                    class="flex text-center justify-left my-2"
                    v-for="role in user_info.roles"
                    :key="role.id"
                >
                    <IdentificationIcon class="h-8 w-8 mr-2" />
                    <h5
                        class="my-auto bg-purple-300 text-slate-700 px-5 py-2 rounded-lg"
                    >
                        {{ role.name }}
                    </h5>
                </div>
            </div>

            <div
                class="text-center mx-auto mt-3 align-middle overflow-auto w-full"
            >
                <table>
                    <thead class="bg-slate-400 text-white h-10 uppercase">
                        <tr>
                            <th class="px-3">Date</th>
                            <th class="px-32">
                                <div class="flex text-center">
                                    <SpeakerWaveIcon
                                        class="h-6 w-6 mr-2 text-blue-600"
                                    />Announcement
                                </div>
                            </th>
                            <th class="px-3">From</th>
                        </tr>
                    </thead>
                    <tbody
                        class="text-left bg-slate-200 text-slate-800 font-sans"
                    >
                        <tr
                            v-if="announcement.length"
                            v-for="announcement_info in announcement"
                            :key="announcement_info.id"
                            class=""
                        >
                            <td class="px-3 py-3">
                                {{ showToday(announcement_info.created_at) }}
                            </td>
                            <td class="px-3 py-3">
                                {{ announcement_info.message }}
                            </td>
                            <td class="px-3 py-3">
                                {{ announcement_info.from_user.name }}
                            </td>
                        </tr>
                        <tr v-else class="text-center mt-2 bg-slate-200">
                            <td colspan="3" class="py-3 font-bold font-sans">
                                No announcement
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="text-left mt-3 overflow-auto w-full"
                v-for="user_info in user"
                :key="user_info.id"
            >
                <table class="table table-hover">
                    <thead
                        class="bg-slate-600 text-white h-10 uppercase text-center"
                    >
                        <tr>
                            <th class="px-3">Date</th>
                            <th class="px-32 flex">
                                <div class="flex text-center">
                                    <BellAlertIcon
                                        class="h-5 w-5 mr-2 text-yellow-300"
                                    />Personal Reminder
                                </div>
                                <button>
                                    <PlusCircleIcon
                                        class="ml-2 h-4 w-4 text-green-300"
                                        @click="showModal"
                                    />
                                </button>
                            </th>
                            <th class="px-3">From</th>
                            <th class="px-3">To</th>
                        </tr>
                    </thead>
                    <tbody
                        class="text-left bg-slate-400 text-white font-sans"
                        v-if="
                            user_info['reminder_from'].length ||
                            user_info['reminder_to'].length
                        "
                    >
                        <tr
                            v-for="reminder in user_info['reminder_from']"
                            :key="reminder.id"
                            class="py-2"
                        >
                            <td class="px-2 py-2">
                                {{ showToday(reminder.created_at) }}
                            </td>
                            <td class="px-2 py-2">
                                {{ reminder.message }}
                            </td>
                            <td class="text-center">
                                <div class="flex">
                                    <div
                                        class="w-max"
                                        v-for="user in users"
                                        :key="user.id"
                                    >
                                        <span
                                            class="mx-2"
                                            v-if="
                                                user.id ===
                                                reminder.from_user_id
                                            "
                                        >
                                            {{ user.name }}</span
                                        >
                                        <span v-else></span>
                                    </div>
                                    <div class="justify-end">
                                        <button
                                            v-if="
                                                reminder.from_user_id ===
                                                this.currentLoggedInUserID
                                            "
                                            class="uppercase text-xs ml-2 bg-red-400 hover:bg-red-600 px-1 py-1 w-max rounded-md"
                                            @click="deleteMessage(reminder.id)"
                                        >
                                            <TrashIcon
                                                class="h-3 w-3 my-auto text-center"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="">
                                <div
                                    class="w-max justify-center"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        class="mx-2"
                                        v-if="user.id === reminder.to_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-for="reminder in user_info['reminder_to']"
                            :key="reminder.id"
                            class="py-1 mt-2"
                        >
                            <td class="px-2 py-2">
                                {{ showToday(reminder.created_at) }}
                            </td>
                            <td class="px-2 py-2">
                                {{ reminder.message }}
                            </td>
                            <td class="text-center">
                                <div
                                    class="w-max"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        v-if="user.id === reminder.from_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                            <td class="flex">
                                <div
                                    class="w-max justify-center"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        v-if="user.id === reminder.to_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else class="text-center mt-2 bg-slate-200">
                        <td colspan="4" class="py-3 font-bold font-sans">
                            No reminder
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <Modal v-show="isModalVisible" @close="closeModal">
            <template #header>
                <div
                    class="text-center justify-center bg-slate-400 text-white rounded-md px-20 py-2 uppercase font-mono mx-auto"
                >
                    <h3>New Reminder</h3>
                </div>
            </template>

            <template #body>
                <div v-if="errors">
                    <div v-for="(v, k) in errors" :key="k">
                        <p
                            v-for="error in v"
                            :key="error"
                            class="text-xs bg-red-500 text-white rounded font-bold shadow-lg py-2 px-4 pr-0 w-max"
                        >
                            {{ error }}
                        </p>
                    </div>
                </div>
                <div>
                    <textarea
                        cols="30"
                        rows="6"
                        class="form-control"
                        v-model="new_reminder.message"
                    />
                </div>

                <div class="text-center">
                    <button
                        class="bg-green-400 px-2 py-2 rounded-md"
                        @click="addReminder"
                    >
                        Save
                    </button>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script>
import moment from "moment";
import AdminPermissionAddViaRole from "./AdminPermissionAddViaRole.vue";
import AdminUserRolePermissionEdit from "./AdminUserRolePermissionEdit.vue";
import Modal from "../utils/Modal.vue";

import {
    UserIcon,
    IdentificationIcon,
    SpeakerWaveIcon,
    BellAlertIcon,
    PlusCircleIcon,
    TrashIcon,
} from "@heroicons/vue/24/solid";
import axios from "axios";

const currentLoggedInUserID = Number(
    document.querySelector('meta[name="user-id"]').getAttribute("content")
);

export default {
    components: {
        UserIcon,
        IdentificationIcon,
        AdminPermissionAddViaRole,
        AdminUserRolePermissionEdit,
        SpeakerWaveIcon,
        BellAlertIcon,
        PlusCircleIcon,
        TrashIcon,
        Modal,
    },

    data() {
        return {
            moment: moment,
            user: [],
            announcement: [],
            users: [],
            isModalVisible: false,
            errors: [],
            to_user_id: [currentLoggedInUserID],
            from_user_id: currentLoggedInUserID,
            currentLoggedInUserID: currentLoggedInUserID,

            new_reminder: {
                id: "",
                message: "",
            },

            reminder_errors: "",
        };
    },

    mounted() {
        this.getUsers();
        this.getUser();
    },

    watch: {},

    methods: {
        showModal() {
            console.log(currentLoggedInUserID);
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },

        async addReminder() {
            try {
                if (!window.confirm("Confirm create?")) {
                    return;
                }
                await axios.post("/api/admin/announcement_reminder/create", {
                    message: this.new_reminder.message,
                    from_user_id: this.from_user_id,
                    message_type_id: 2,
                    // to_user_id: this.to_user_id
                });
                alert("Announcement/reminder created.");
                this.new_reminder.message = "";
                this.errors = [];
                this.isModalVisible = false;
                this.getUser();
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async deleteMessage(annc_reminder_id) {
            if (!window.confirm("Delete message?")) {
                return;
            }
            await axios.delete(
                "/api/admin/announcement_reminder/delete/" + annc_reminder_id
            );
            alert("Announcement/reminder deleted.");
            this.getUser();
        },

        async getUser() {
            await axios
                .get("/api/users/home")
                .then((res) => {
                    this.user = res.data.data;
                    this.announcement = res.data.data2;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>
