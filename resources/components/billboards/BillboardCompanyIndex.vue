<template>
    <div class="flex">
        <div class="">
            <table
                class="table table-hover table-bordered w-max"
                id="summary_table"
            >
                <thead class="bg-slate-600 border-b sticky top-0">
                    <tr class="">
                        <th class="h-20 align-middle">
                            <div class="text-xs text-center h-6 text-white">
                                No.
                            </div>
                        </th>
                        <th class="h-20 align-middle">
                            <div class="text-xs text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('site_id')"
                                    class="text-white inline-flex"
                                    ><div class="inline-flex">Site No.</div>

                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(
                                                    sort_direction == 'desc'
                                                )) &&
                                            !(sort_field == 'site_id')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'site_id'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'site_id'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                            </div>
                        </th>

                        <th class="h-20 align-middle">
                            <div class="text-xs text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('bboard_location')
                                    "
                                    class="text-white inline-flex"
                                    ><div class="inline-flex">Location</div>

                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(
                                                    sort_direction == 'desc'
                                                )) &&
                                            !(
                                                sort_field ==
                                                'bboard_location'
                                            )
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'bboard_location'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'bboard_location'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                            </div>
                        </th>
                        <th class="h-20 align-middle">
                            <div class="text-xs text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('bboard_size')
                                    "
                                    class="text-white inline-flex"
                                    ><div class="inline-flex">Size</div>

                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(
                                                    sort_direction == 'desc'
                                                )) &&
                                            !(sort_field == 'bboard_size')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'bboard_size'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'bboard_size'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                            </div>
                        </th>

                        <th class="h-20 align-middle">
                            <div class="text-xs text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('company_name')
                                    "
                                    class="text-white inline-flex"
                                    ><div class="inline-flex">Company</div>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-xs font-bold bg-gray-500 text-black">
                    <tr
                        class="h-20"
                        v-for="(billboard, index) in billboards.data"
                        :key="billboard.id"
                    >
                        <td class="text-white text-left font-bold">
                            {{ index + 1 }}
                        </td>
                        <td>
                            <div
                                v-if="
                                    can('edit billboard') ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="text-black text-left w-max"
                            >
                                <router-link
                                    :to="`/billboard/${billboard.id}/tenure`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a
                                        class="text-blue-300 font-bold text-left"
                                        :href="href"
                                        @click.stop="navigate"
                                        >{{ billboard.site_id }}</a
                                    >
                                </router-link>
                            </div>
                            <div v-else class="my-1 w-max">
                                {{ billboard.site_id }}
                            </div>
                        </td>
                        <td class="text-white font-bold text-left">
                            {{ billboard.bboard_location }}
                        </td>
                        <td class="text-white font-bold text-left">
                            {{ billboard.bboard_size }}
                        </td>
                        <td class="w-max text-left">
                            <tr
                                v-for="tenure in billboard.summary"
                                :key="tenure.id"
                                class="border-2 border-slate-500"
                            >
                                <div class="w-max grid-cols-1 gap-1 px-2">
                                    <div>
                                        <td>
                                            <router-link
                                                :to="`/contact/${tenure.company_id}/info`"
                                                custom
                                                v-slot="{ navigate, href }"
                                            >
                                                <a
                                                    class="text-blue-300 font-bold text-left"
                                                    :href="href"
                                                    @click.stop="navigate"
                                                    >{{
                                                        tenure.company_name
                                                    }}</a
                                                >
                                            </router-link>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- scrollable-->
        <div class="overflow-x-auto">
            <table
                class="table table-hover table-bordered w-max"
                id="summary_table"
            >
                <thead class="bg-slate-600 border-b sticky top-0">
                    <tr class="">
                        <template v-for="month in months"
                        :key="month.no"
                        >
                            <th
                                class="h-20"
                                :colspan="
                                    getTotalISOWeeksInMonth(
                                        this.selectedYear,
                                        month.no
                                    )
                                "
                            >
                                <div
                                    class="text-white text-xs h-6 text-center"
                                >
                                    {{ month.short_name }}
                                </div>
                                <th
                                    v-for="week in getTotalISOWeeksInMonth(
                                        this.selectedYear,
                                        month.no
                                    )"
                                    class="mx-auto px-2"

                                >
                                    <div
                                        class="text-white text-xs h-6 text-center px-2 mx-auto w-14"
                                    >
                                        {{ week }}
                                    </div>
                                </th>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody class="text-xs font-bold bg-gray-500 text-black">
                    <tr
                        class="h-20"
                        v-for="(billboard, index) in billboards.data"
                        :key="billboard.id"
                    >
                        <template v-for="week in total_weeks_in_year">
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                        tenure.week_start == `${this.selectedYear}-${week}` ||
                                        tenure.week_end == `${this.selectedYear}-${week}`
                                        "
                                    >
                                        <div
                                            v-if=" tenure.week_start == `${this.selectedYear}-${week}`
                                            "
                                            class="bg-green-400 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if=" tenure.week_end == `${this.selectedYear}-${week}`
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            showSummary(tenure, this.selectedYear, week)
                                        "
                                        class="bg-green-300 text-center w-16 px-1 text-transparent font-bold border-2 border-slate-500"
                                    >
                                        mid
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 text-transparent font-bold border-2 border-slate-500"
                                    >
                                        no
                                    </td>
                                </tr>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
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

export default {
    props: ["selected_year", "query"],

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
    },

    mounted() {

        this.getBillboardSizes();
        this.getBillboards();
        this.selectedYear = this.$props.selected_year;
        this.calculateTotalWeeksInYear(this.$props.selected_year);

    },
    data() {
        return {
            tenures: [],
            billboard_sizes: [],
            contacts: [],
            billboards: [],

            paginate: 50,
            moment: moment,

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

            total_weeks_in_year: Number,

            months: [
                {
                    name: "January",
                    short_name: "Jan",
                    no: 1,
                },
                {
                    name: "February",
                    short_name: "Feb",
                    no: 2,
                },
                {
                    name: "March",
                    short_name: "Mac",
                    no: 3,
                },
                {
                    name: "April",
                    short_name: "Apr",
                    no: 4,
                },
                {
                    name: "May",
                    short_name: "May",
                    no: 5,
                },
                {
                    name: "June",
                    short_name: "Jun",
                    no: 6,
                },
                {
                    name: "July",
                    short_name: "Jul",
                    no: 7,
                },
                {
                    name: "August",
                    short_name: "Aug",
                    no: 8,
                },
                {
                    name: "September",
                    short_name: "Sep",
                    no: 9,
                },
                {
                    name: "October",
                    short_name: "Oct",
                    no: 10,
                },
                {
                    name: "November",
                    short_name: "Nov",
                    no: 11,
                },
                {
                    name: "December",
                    short_name: "Dec",
                    no: 12,
                },
            ],
        };
    },
    watch: {
        paginate: function (value) {
            this.getBillboards();
        },
        search: function (value) {
            this.getBillboards();
        },
        selected_year() {

            this.selectedYear = this.$props.selected_year;

        },
        selectedYear: function (value) {
            this.getBillboards();
        },
        selectedSite: function (value) {
            this.getBillboards();
        },
        selectedSize: function (value) {
            this.getBillboards();
        },
    },

    computed: {

    },

    methods: {

        showSummary(summary, selectedYear, currentWeekNo) {
            var displaySummary = false;

            let week_start = this.getISOWeekNumber(new  Date(summary.tenure_startdate));
            let week_end = this.getISOWeekNumber(new Date(summary.tenure_enddate));

            if(currentWeekNo >= week_start  &&  currentWeekNo <= week_end) {
                displaySummary = true;
            }
            else if(this.checkDate(summary.tenure_startdate, summary.tenure_enddate, currentWeekNo))
            {
                displaySummary = true;
            }
            return displaySummary;
        },
        checkWeek(tenures, selectedYear, currentWeekNo)
        {
            var summaryExist = false;

            for(let i = 0; i < tenures.length; i++) {
                let week_start = this.getISOWeekNumber(new  Date(tenures[i].tenure_startdate));
                let week_end = this.getISOWeekNumber(new Date(tenures[i].tenure_enddate));

                if(currentWeekNo >= week_start  &&  currentWeekNo <= week_end) {
                    summaryExist = true;
                }

            }

            return summaryExist;
        },

        checkDate(date_start, date_end, week_no)
        {
            let week_date = new Date(this.getDateFromWeek(`${this.selectedYear}-${week_no}`));

            let start_date = new Date(date_start);

            let end_date = new Date(date_end);

            if(week_date >= start_date  &&  week_date <= end_date) {
                return true;
            }
        },

        getDateFromWeek(year_week)
        {
            const [year, weekNo] = year_week.split('-');

            // Calculate the date of the first day of the week
            const januaryFourth = new Date(`${year}-01-04`); // January 4th is always in the first week
            const daysToFirstWeekStart = (januaryFourth.getDay() + 6) % 7; // Adjust for Sunday being 0
            const firstWeekStartDate = new Date(januaryFourth.setDate(januaryFourth.getDate() - daysToFirstWeekStart));
            const targetDate = new Date(firstWeekStartDate.setDate(firstWeekStartDate.getDate() + (Number(weekNo) - 1) * 7));

            // Extract the date as a string in the format "YYYY-MM-DD"
            const extractedDate = targetDate.toISOString().split('T')[0];

            return extractedDate;
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
                        this.$props.selected_year
                )
                .then((res) => {
                    this.buffering = false;
                    this.billboards = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getBillboardSites() {
            await axios
                .get("/api/billboards/site")
                .then((res) => {
                    this.billboard_sites = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getBillboardSizes() {
            await axios
                .get("/api/billboards/size")
                .then((res) => {
                    this.billboard_sizes = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getBillboards();
        },

        getWeekNumber(year, month) {
            const firstDayOfMonth = new Date(year, month - 1, 1);
            const firstDayOfWeek = firstDayOfMonth.getDay();
            const offset = (firstDayOfWeek < 5) ? 1 - firstDayOfWeek : 8 - firstDayOfWeek;

            const firstWeekStart = new Date(year, month - 1, 1 + offset);
            const weekNumber = Math.ceil((firstDayOfMonth.getDate() + offset) / 7);

            return weekNumber;
        },

        getTotalISOWeeksInYear(year) {
            // Create a new date object for the last day of the year
            const lastDayOfYear = new Date(year, 11, 31);

            // Calculate the ISO week number of the last day of the year
            const lastWeekNumber = this.getISOWeekNumber(lastDayOfYear);

            return lastWeekNumber;
        },

        getISOWeekNumber(date) {
            // Copy the date so that it doesn't modify the original
            const newDate = new Date(date);

            // Set the time to midnight to avoid issues with daylight saving time
            newDate.setHours(0, 0, 0);

            // Find the Thursday of the current week to determine the starting point of the ISO week
            newDate.setDate(newDate.getDate() + 3 - (newDate.getDay() + 6) % 7);

            // Set the starting point of the ISO week to the beginning of the year
            const startOfYear = new Date(newDate.getFullYear(), 0, 1);

            // Calculate the week number
            const weekNumber = Math.ceil(((newDate - startOfYear) / 86400000 + 1) / 7);

            return weekNumber;
        },

        getTotalISOWeeksInMonth(year, month) {
            const date = new Date(year, month - 1, 1);
            date.setDate(date.getDate() + 7 - date.getDay());
            const lastDayOfMonth = new Date(year, month, 0).getUTCDate();
            let weekCount = 1;

            while (date.getUTCDate() + 6 <= lastDayOfMonth) {
                date.setDate(date.getDate() + 7);
                weekCount++;
            }

            return weekCount;
        },

        calculateTotalWeeksInYear(year) {
            var total_weeks = 0

            for (let month = 1; month <= 12; month++) {
                total_weeks = total_weeks + this.getTotalISOWeeksInMonth(year, month)
            }

            return this.total_weeks_in_year = total_weeks;
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

        checkMonth(month, start_date, end_date) {
            const date = new Date(month);

            const start = new Date(start_date);
            const end = new Date(end_date);

            if (date > start && date < end) {
                // console.log("✅ date is between the 2 dates");
                return true;
            } else {
                // console.log("⛔️ date is not in the range");
                return false;
            }
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
