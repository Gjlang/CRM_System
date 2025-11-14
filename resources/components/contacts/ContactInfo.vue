<template>
    <div v-for="info in contact_infos" :key="contact_infos.id">
        <div class="container w-max -4 align-center mx-auto h-max">
            <div class="max-h-10 mb-2 ml-4 h-9">
                <GoBack class="" />
            </div>

            <div
                class="items-center text-center text-white font-extrabold bg-blue-900 px-2 py-1 rounded-md"
            >
                <h1 class="px-2 bg-black-50 uppercase">Company Information</h1>
            </div>
            <div class="grid grid-cols-3 text-left">
                <div class="uppercase my-auto">Name</div>
                <div
                    class="cols-span-2 px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap my-auto"
                >
                    {{ info.name }}
                </div>
                <div class="text-right mt-2">
                    <div class="flex">
                        <router-link
                            :to="{
                                name: 'todo_insert',
                                params: { id: info.id },
                            }"
                            class="flex w-max bg-green-400 text-center px-1 py-1 transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PlusCircleIcon class="inline-flex h-6 w-6 mr-1" />
                            To Do
                        </router-link>
                        <router-link
                            :to="{
                                name: 'contacts_edit',
                                params: { id: info.id },
                            }"
                            class="flex w-max text-right px-2 py-1 bg-yellow-400 -transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-6 w-6" />
                        </router-link>
                    </div>
                </div>
                <div class="uppercase my-auto">Industry</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.industry.name }}
                </div>
                <div class="uppercase my-auto">Category</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.category.name }}
                </div>
                <div class="uppercase my-auto">Status</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.status.name }}
                </div>
                <div class="uppercase my-auto">Type</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.type.name }}
                </div>
                <div class="uppercase my-auto">Address</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.address }}
                </div>
                <div class="uppercase my-auto">CS</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    {{ info.user.name }}
                </div>
                <div class="uppercase my-auto">History</div>
                <div
                    class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 my-auto"
                >
                    <router-link
                        :to="{
                            name: 'contacts_history',
                            params: { id: info.id },
                        }"
                        class="mr-2 mb-2 inline-flex items-center px-1 py-1 bg-blue-400 -transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <BookOpenIcon class="h-8 w-8" />
                    </router-link>
                </div>
            </div>
            <div class="">
                <h5
                    class="text-center text-white font-extrabold font-mono text-sm uppercase bg-blue-900 px-5 py-2 rounded-md"
                >
                    PIC
                </h5>
                <div class="text-right inline-block">
                    <router-link
                        :to="{
                            name: 'incharge_create',
                            params: { id: info.id },
                        }"
                        class="inline-flex text-center px-1 py-1 transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <div
                            class="bg-green-400 inline-flex rounded-md align-middle px-1"
                        >
                            <PlusIcon
                                class="h-8 w-8 bg-green-400 py-1 px-1 rounded-md"
                            />
                            <p class="text-center my-auto">PIC</p>
                        </div>
                        <PencilSquareIcon
                            class="h-8 w-8 bg-yellow-400 py-1 px-1 rounded-md"
                        />
                    </router-link>
                </div>
            </div>

            <div
                class="w-full text-left text-neutral-300 my-2 py-2 border-gray-800 grid grid-cols-2 lg:grid-cols-11"
                v-for="(pic, index) in info.incharge"
                v-if="info.incharge.length !== 0"
                :key="info.incharge.id"
            >
                <div class="lg:grid lg:grid-cols-9 lg:col-span-3">
                    <div
                        class="hidden lg:block sm:bg-cyan-700 sm:px-2 sm:py-1 sm:font-semibold sm:font-mono sm:rounded-md sm:col-span-1"
                    >
                        {{ index + 1 }}
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap col-span-2"
                    >
                        Name:
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-6"
                    >
                        {{ pic.name }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-4 lg:col-span-3">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap w-max col-span-1"
                    >
                        Email:
                    </div>
                    <div
                        class="w-max px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-3"
                    >
                        {{ pic.email }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-2 lg:col-span-2">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                    >
                        Phone No. (Mobile):
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ pic.phone_mobile }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-3 lg:col-span-2">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                    >
                        Phone No. (Office):
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ pic.phone_office }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-1 lg:col-span-1 flex">
                    <div class="w-max">
                        <router-link
                            :to="{
                                name: 'incharge_edit',
                                params: { id: pic.id },
                            }"
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-3 w-3" />
                        </router-link>
                    </div>
                    <div class="w-max">
                        <button
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click="deletePIC(pic.id)"
                        >
                            <TrashIcon class="h-3 w-3" />
                        </button>
                    </div>
                </div>
            </div>
            <div
                v-else
                class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
            >
                <h1><strong>No PIC </strong></h1>
            </div>

            <div class="">
                <h5
                    class="text-center text-white font-extrabold font-mono text-sm uppercase bg-blue-900 px-5 py-2 rounded-md my-3"
                >
                    Forecast
                </h5>
                <div class="w-max my-auto">
                    <router-link
                        :to="`/forecast/${info.id}/create`"
                        class="mr-2 mb-2 px-2 py-1 items-center border text-xs text-right rounded-lg w-max text-white bg-emerald-600 flex hover:bg-emerald-800"
                    >
                        <PlusIcon class="h-5 w-5 my-auto" />
                        <DocumentChartBarIcon class="h-5 w-5 my-auto"
                    /></router-link>
                </div>
            </div>
            <div
                class="w-full text-left text-neutral-300 my-2 py-2 border-gray-800 grid grid-cols-2 lg:grid-cols-7"
                v-if="info.forecast.length !== 0"
                v-for="(forecast_info, index) in info.forecast"
                :key="forecast_info.id"
            >
                <div class="lg:grid lg:grid-cols-10 lg:col-span-2">
                    <div
                        class="hidden lg:block lg:bg-cyan-700 lg:px-2 lg:py-1 lg:font-semibold lg:font-mono lg:rounded-md lg:col-span-1"
                    >
                        {{ index + 1 }}
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap col-span-3"
                    >
                        Product:
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-6"
                    >
                        {{ forecast_info.product.name }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-4 lg:col-span-2">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap w-max col-span-2"
                    >
                        Amount(RM):
                    </div>
                    <div
                        class="w-max px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2 text-right"
                    >
                        {{ forecast_info.amount.toLocaleString("en-US") }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-2">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                    >
                        Forecast Type:
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ forecast_info.forecast_type.name }}
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-3">
                    <div
                        class="px-1 py-1 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                    >
                        Date:
                    </div>
                    <div
                        class="px-1 py-1 text-sm leading-5 font-bold text-gray-900 whitespace-no-wrap col-span-2"
                    >
                        {{ showToday(forecast_info.forecast_date) }}
                    </div>
                </div>
                <div class="flex lg:flex-col lg:grid lg:grid-cols-1">
                    <div class="w-max">
                        <router-link
                            :to="{
                                name: 'forecast_edit',
                                params: {
                                    id: forecast_info.id,
                                },
                            }"
                            class="mr-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-3 w-3" />
                        </router-link>
                    </div>

                    <div class="w-max">
                        <button
                            class="mr-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click="deleteForecast(forecast_info.id)"
                        >
                            <TrashIcon class="h-3 w-3" />
                        </button>
                    </div>
                </div>
            </div>
            <div
                v-else
                class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
            >
                <h1><strong>No Forecast </strong></h1>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GoBack from "../utils/GoBack.vue";
import moment from "moment";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
    BookOpenIcon,
    DocumentChartBarIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        GoBack,
        PencilSquareIcon,
        TrashIcon,
        PlusCircleIcon,
        PlusIcon,
        PencilIcon,
        BookOpenIcon,
        DocumentChartBarIcon,
    },

    data() {
        return {
            info: "",
            contact_infos: [],
            moment: moment,
        };
    },

    mounted() {
        this.showContact();
    },

    methods: {
        showContact() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact_infos = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deletePIC(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/incharges/delete/" + id);
            this.$router.push({
                name: "contacts_info",
                params: { id: this.$route.params.id },
            });
            this.showContact();
        },

        deleteForecast(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/forecasts/delete/" + id);
            this.$router.push({
                name: "contacts_info",
                params: { id: this.$route.params.id },
            });
            this.showContact();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>
