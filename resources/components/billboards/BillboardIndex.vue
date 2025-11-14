<template>
    <div class="w-full min-h-screen">
        <h1
            class="items-center text-center sm:text-4xl text-white font-extrabold font-mono uppercase bg-orange-500 px-2 rounded-md"
        >
            Billboard Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-1 sm:grid-cols-4 items-center">
                <div class="flex">
                    <div
                        class="items-center px-2 text-xs lg:text-sm w-max"
                        v-if="
                            can('create billboard') ||
                            is('supervisor | admin | super-admin')
                        "
                    >
                        <router-link
                            to="/billboard/create"
                            class="flex items-center px-2 py-1 align-top bg-blue-800 border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PlusIcon
                                class="inline h-4 w-4 lg:h-6 lg:w-6 mr-1"
                            />
                            <span class="text-xs lg:text-sm my-auto"
                                >Billboard</span
                            >
                        </router-link>
                    </div>
                    <div
                        class="uppercase w-max bg-green-500 px-1 py-1 rounded-md "
                        v-if="
                            can('export billboard') || is('admin | super-admin')
                        "
                    >
                        <download-excel
                            :data="billboards.data"
                            :fields="billboard_fields"
                            worksheet="Billboard Summary"
                            name="Billboard Summary.xls"
                            class="flex w-maxmy-auto hover:cursor-pointer"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-3 w-3 lg:h-6 lg:w-6 mr-1 inline-block"
                            />
                            <span class="text-xs lg:text-sm my-auto"
                                >Export</span
                            >
                        </download-excel>
                    </div>
                </div>

                <div class="mx-2">
                    <label>
                        View By
                    </label>
                    <select
                        v-model="view_type"
                        class="form-control text-sm h-max"
                    >
                        <option class="text-sm" value="summary">
                            Summary
                        </option>
                        <option class="text-sm" value="company">
                            Company
                        </option>
                    </select>
                </div>

                <div class="grid grid-cols-1 items-left m-2">
                    <label>Year</label>
                    <input
                        v-model.lazy="selectedYear"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
            </div>

            <div v-if="view_type == 'summary' && prop_selected_year">
                <BillboardSummaryIndex
                :selected_year="prop_selected_year"
                :query="this.search"
                />
            </div>

            <div v-if="view_type == 'company' && prop_selected_year">
                <BillboardCompanyIndex
                @change="this.propSelectedYear(selectedYear)"
                :selected_year="prop_selected_year"
                :query="search"
                />
            </div>

        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import {
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
} from "@heroicons/vue/24/solid";
import moment from "moment";
import BillboardSummaryIndex from "./BillboardSummaryIndex.vue";
import BillboardCompanyIndex from "./BillboardCompanyIndex.vue";

export default {
    components: {
    Pagination: LaravelVuePagination,
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    BillboardSummaryIndex,
    BillboardCompanyIndex
},

    mounted() {
        this.getSelectedYear(this.getCurrentDate());
        this.prop_selected_year = this.selectedYear;
        this.getBillboards()

        // console.log(this.billboards)
    },

    data() {
        return {
            tenures: [],
            billboard_sizes: [],
            contacts: [],
            billboards: [],

            paginate: 50,
            moment: moment,
            view_type: 'summary',

            search: "",
            selectedYear: "",
            selectedSite: "",
            selectedSize: "",
            sort_direction: "desc",
            sort_field: "site_id",

            sort_direction: "asc",
            sort_field: "site_id",
            currentDate: "",
            buffering: false,
            prop_selected_year: null,

            billboard_fields: {
                "Site No.": "site_id",
                Location: "bboard_location",
                Size: "bboard_size",
                Company: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let new_arr = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                new_arr.push(
                                    `(${index})` + " " + arr[x].company_name
                                );
                            }

                            return `${new_arr}`;
                        }
                    },
                },

                Jan: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-01"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-01"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-02"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-02"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Mac: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-03"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-03"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-04"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-04"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-05"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-05"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-06"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-06"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-07"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-07"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-08"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-08"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-09"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-09"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-10"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-10"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-11"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-11"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        if (value.summary.length === 0) {
                            return " ";
                        } else {
                            let arr = value.summary;
                            let startdate = [];
                            let enddate = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_startdate) ===
                                    this.selectedYear + "-12"
                                ) {
                                    startdate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_startdate
                                            )
                                    );
                                } else {
                                    //startdate.push("");
                                }
                            }

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                if (
                                    this.getMonth(arr[x].tenure_enddate) ===
                                    this.selectedYear + "-12"
                                ) {
                                    enddate.push(
                                        `(${index})` +
                                            " " +
                                            this.showToday(
                                                arr[x].tenure_enddate
                                            )
                                    );
                                } else {
                                    //enddate.push("");
                                }
                            }
                            return `S:${startdate} \n F:${enddate}`;
                        }
                    },
                },
            },
        };
    },
    watch: {
        paginate: function (value) {
            // this.getBillboards();
        },
        search: function (value) {
            // this.getBillboardsWithParam();
        },
        selectedYear: function (value) {
            this.prop_selected_year = this.selectedYear;
            this.getBillboards();
        },
        selectedSite: function (value) {
            // this.getBillboards();
        },
        selectedSize: function (value) {
            // this.getBillboards();
        },
    },

    computed: {},

    methods: {

        propSelectedYear(year) {
            this.prop_selected_year = year;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },

        getMonth(date) {
            let day = moment(date).format("YYYY-MM");
            return day;
        },

        getBillboards(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/billboards/index?" +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field +
                        "&selectedYear=" +
                        this.selectedYear
                )
                .then((res) => {
                    this.buffering = false;
                    this.billboards = res.data;
                    // console.log(this.billboards.data)
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
