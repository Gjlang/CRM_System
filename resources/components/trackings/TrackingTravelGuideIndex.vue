<template>
    <div class="w-full min-h-screen">
        <h1
            class="items-center text-center lg:text-5xl text-white font-extrabold bg-orange-500 px-2 rounded-md"
        >
            Tracking - Travel Guide
        </h1>

        <div class="flex">
            <div
                class="py-2 px-2"
                v-if="
                    can('create tracking travelguide') ||
                    is('admin | super-admin')
                "
            >
                <router-link
                    :to="{ name: 'tracking_travel_guide_create' }"
                    class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-xs sm:text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PlusIcon class="inline h-3 w-3 sm:h-5 sm:w-5 mr-1" />
                    Tracking</router-link
                >
            </div>

            <div class="py-2 px-2">
                <div
                    class="px-2"
                    v-if="
                        (can('export travel guide master') ||
                            is('admin | super-admin')) &&
                        (view_type === 'master' ||
                            view_type === 'master_report')
                    "
                >
                    <download-excel
                        :data="tracking_travel_guides.data"
                        :fields="tguide_master_fields"
                        worksheet="Travel Guide Summary"
                        name="Travel Guide Master.xls"
                        class="btn btn-success btn-sm text-xs sm:text-lg"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-3 w-3 sm:h-5 sm:w-5 mr-1 inline-block"
                        />
                        Export Master
                    </download-excel>
                </div>
                <!-- <div
                    class="px-2"
                    v-if="
                        (can('export travel guide wip') ||
                            is('admin | super-admin')) &&
                        (view_type === 'wip' || view_type === 'wip_report')
                    "
                >
                    <download-excel
                        :data="tracking_travel_guides.data"
                        :fields="tguide_wip_fields"
                        worksheet="Travel Guide Summary"
                        name="Travel Guide WIP.xls"
                        class="btn btn-success btn-sm text-xs sm:text-lg flex"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-3 w-3 sm:h-5 sm:w-5 mr-1 inline-block"
                        />
                        Export WIP
                    </download-excel>
                </div> -->
                <div
                    class="px-2"
                    v-if="
                        (can('export travel guide wip') ||
                            is('admin | super-admin')) &&
                        (view_type === 'wip' || view_type === 'wip_report')
                    "
                >
                    <download-excel
                        :data="tracking_travel_guides.data"
                        :fields="summary_wip_fields"
                        worksheet="Travel Guide Summary"
                        name="Travel Guide WIP.xls"
                        class="btn btn-success btn-sm text-xs sm:text-lg flex"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-3 w-3 sm:h-5 sm:w-5 mr-1 inline-block"
                        />
                        Export WIP
                    </download-excel>
                </div>
                <!-- <div
                    class="inline-block my-auto"
                >
                    <button
                        class="bg-green-500 px-2 py-2 rounded-lg text-xs"
                        @click="exportExcel('xls')"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-3 w-3 sm:h-5 sm:w-5 mr-1 inline-block"
                        />Export
                    </button>
                </div> -->
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-11 gap-2">
            <div class="grid grid-cols-2 items-center text-right lg:col-span-2">
                <label for="paginate" class="mr-2">Per page</label>
                <input
                    v-model.lazy="paginate"
                    class="form-control w-max text-xs"
                />
            </div>
            <div class="grid grid-cols-2 items-center text-right lg:col-span-2">
                <label for="paginate" class="mr-2 text-sm">Year</label>
                <input v-model.lazy="selectedYear" class="form-control w-max" />
            </div>
            <div class="grid grid-cols-2 lg:col-span-2 items-center text-right">
                <label for="view_type" class="mr-2">View</label>
                <select v-model="view_type" class="form-control">
                    <option value="">Select one</option>
                    <option value="master">Master</option>
                    <option value="wip">WIP</option>
                    <option value="master_report">Report (Master)</option>
                    <option value="wip_report">Report (WIP)</option>
                </select>
            </div>
            <div class="py-2 lg:mx-8 col-span-2 sm:col-span-3 lg:col-span-3">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>
            <div class="mt-1 col-span-2">
                <Pagination
                    :data="tracking_travel_guides"
                    :limit="2"
                    @pagination-change-page="getTrackingTravelGuides"
                    :size="'small'"
                    :align="'center'"
                    class="pagination"
                />
            </div>
        </div>

        <div>
            <div v-if="view_type === 'wip'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-amber-600 px-2 rounded-md"
                >
                    Work In Progress
                </h3>
            </div>
            <div v-if="view_type === 'master'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-blue-500 px-2 rounded-md"
                >
                    Master Record
                </h3>
            </div>
            <div v-if="view_type === 'master_report'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-blue-800 px-2 rounded-md"
                >
                    Master Report
                </h3>
            </div>
            <div v-if="view_type === 'wip_report'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-amber-800 px-2 rounded-md"
                >
                    Work In Progress Report
                </h3>
            </div>
            <div
                v-if="view_type === 'master'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_master_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_reminder_date')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Reminder
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'art_reminder_date'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'art_reminder_date'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'art_reminder_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_record_date')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Received
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'art_record_date'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_record_date'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_record_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <template v-for="month in months">
                                <th class="border py-3">
                                    <div class="text-sm text-center h-12">
                                        <a
                                            href="#"
                                            @click.prevent="change_sort('')"
                                            class="text-white inline-flex"
                                        >
                                            {{
                                                getObjectKeyFromValue(
                                                    months,
                                                    month
                                                )
                                            }}
                                        </a>
                                    </div>
                                </th>
                            </template>

                            <th class="border py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>

                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_reminder_date &&
                                    !tracking.art_reminder_user_id &&
                                    !tracking.art_reminder_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_record_date &&
                                    !tracking.art_record_user &&
                                    !tracking.art_record_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <template v-for="month in months">
                                <!-- td for package name -->
                                <td
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mb-1"
                                    >
                                        <div
                                            class="border rounded-md p-2 bg-slate-200"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <button
                                                class="bg-slate-200"
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                @click="
                                                    showModal(tguide_package.id)
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="border text-xs" v-else>
                                    <div class="w-6"></div>
                                </td>
                            </template>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'wip'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <template v-for="month in months">
                                <th class="border py-3" colspan="2">
                                    <div class="text-sm text-center h-12">
                                        <a
                                            href="#"
                                            @click.prevent="change_sort('')"
                                            class="text-white inline-flex"
                                        >
                                            {{
                                                getObjectKeyFromValue(
                                                    months,
                                                    month
                                                )
                                            }}
                                        </a>
                                    </div>
                                </th>
                            </template>

                            <th class="border py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <template v-for="month in months">
                                <!-- td for package name -->
                                <td
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mb-1"
                                    >
                                        <div
                                            class="border rounded-md p-2 bg-slate-200"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <button
                                                class="bg-slate-200"
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                @click="
                                                    showModal(tguide_package.id)
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="border text-xs" v-else>
                                    <div class="w-6"></div>
                                </td>

                                <!-- td for package done -->
                                <td
                                    style="background-color: #f0f175"
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mb-1 w-6 mt-3"
                                    >
                                        <div
                                            class=""
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_done ==
                                                    1
                                                "
                                            >
                                                <CheckCircleIcon
                                                    class="h-5 w-5"
                                                />
                                            </div>
                                            <!-- <div
                                                v-else
                                                class="text-amber-600"
                                            ></div> -->
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="border text-xs"
                                    style="background-color: #f0f175"
                                    v-else
                                >
                                    <div class="w-6"></div>
                                </td>
                            </template>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'master_report'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_reminder_date')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Reminder
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'art_reminder_date'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'art_reminder_date'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'art_reminder_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_record_date')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Received
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'art_record_date'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_record_date'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_record_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <template v-for="month in months">
                                <th class="border py-3">
                                    <div class="text-sm text-center h-12">
                                        <a
                                            href="#"
                                            @click.prevent="change_sort('')"
                                            class="text-white inline-flex"
                                        >
                                            {{
                                                getObjectKeyFromValue(
                                                    months,
                                                    month
                                                )
                                            }}
                                        </a>
                                    </div>
                                </th>
                            </template>

                            <th class="border py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>

                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_reminder_date &&
                                    !tracking.art_reminder_user_id &&
                                    !tracking.art_reminder_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_record_date &&
                                    !tracking.art_record_user &&
                                    !tracking.art_record_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <template v-for="month in months">
                                <!-- td for package name -->
                                <td
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class=""
                                    >
                                        <div
                                            class="border rounded-md p-2 bg-slate-200 flex m-1"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <button
                                                class="bg-slate-200 flex m-1"
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                @click="
                                                    showModal(tguide_package.id)
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                    
                                </td>
                                <td class="border text-xs" v-else>
                                    <div class="w-6 flex mx-auto"></div>
                                </td>
                            </template>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'wip_report'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <template v-for="month in months">
                                <th class="border py-3" colspan="2">
                                    <div class="text-sm text-center h-12">
                                        <a
                                            href="#"
                                            @click.prevent="change_sort('')"
                                            class="text-white inline-flex"
                                        >
                                            {{
                                                getObjectKeyFromValue(
                                                    months,
                                                    month
                                                )
                                            }}
                                        </a>
                                    </div>
                                </th>
                            </template>

                            <th class="border py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <template v-for="month in months">
                                <!-- td for package name -->
                                <td
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mb-1"
                                    >
                                        <div
                                            class="border rounded-md p-2 bg-slate-200"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <button
                                                class="bg-slate-200"
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                @click="
                                                    showModal(tguide_package.id)
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="border text-xs" v-else>
                                    <div class="w-6"></div>
                                </td>

                                <!-- td for package done -->
                                <td
                                    style="background-color: #f0f175"
                                    class="border text-xs"
                                    v-if="
                                        tracking.wip_travel_guide.length !==
                                            0 &&
                                        checkMonth(
                                            tracking.wip_travel_guide,
                                            `${selectedYear}-${month}`
                                        )
                                    "
                                >
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mb-1 w-6 mt-3"
                                    >
                                        <div
                                            class=""
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-${month}`
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_done ==
                                                    1
                                                "
                                            >
                                                <CheckCircleIcon
                                                    class="h-5 w-5"
                                                />
                                            </div>
                                            <!-- <div
                                                v-else
                                                class="text-amber-600"
                                            ></div> -->
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="border text-xs"
                                    style="background-color: #f0f175"
                                    v-else
                                >
                                    <div class="w-6"></div>
                                </td>
                            </template>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <Modal v-show="isModalVisible" @close="closeModal" class="w-max">
        <template #header>
            <div
                class="text-center justify-center bg-slate-400 text-white rounded-md px-20 py-2 uppercase font-mono mx-auto"
            >
                <h3>Package</h3>
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

            <div
                class="text-center border-2 px-1 py-1 border-slate-300 my-2 flex"
            >
                <div
                    class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    id="form-wrapper"
                >
                    <div class="form-assignment">
                        <label class="font-bold">Package</label>
                        <div class="grid grid-cols-3">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip_travel_guide.wip_package_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-2">
                                <label class="font-bold"
                                    >Name
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                                <select
                                    id="wip_package_user_id"
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getTravelGuidePackages"
                                    v-model="wip_travel_guide.wip_package_name"
                                >
                                    <option value="">Select package</option>
                                    <option
                                        v-for="travel_guide_package in travel_guide_packages"
                                        :key="travel_guide_package.id"
                                        :value="travel_guide_package.name"
                                    >
                                        {{ travel_guide_package.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold"
                                    >Date
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="
                                            wip_travel_guide.wip_package_date
                                        "
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getUsers"
                                    v-model="
                                        wip_travel_guide.wip_package_user_id
                                    "
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users.data"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-1">
                                <label class="font-bold">Note</label>
                                <textarea
                                    v-model="
                                        wip_travel_guide.wip_package_remark
                                    "
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-xs sm:text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button
                    class="bg-green-400 px-2 py-2 rounded-md"
                    @click="saveWIP(wip_travel_guide.id)"
                >
                    Save
                </button>
            </div>
        </template>

        Hello
    </Modal>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import Modal from "../utils/Modal.vue";

import {
    PencilSquareIcon,
    PencilIcon,
    TrashIcon,
    PlusIcon,
    UserPlusIcon,
    DocumentChartBarIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    QuestionMarkCircleIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        PlusIcon,
        UserPlusIcon,
        DocumentChartBarIcon,
        PencilIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        ArrowUpIcon,
        ArrowDownIcon,
        QuestionMarkCircleIcon,
        CheckCircleIcon,
        Modal,
    },

    mounted() {
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.currentDate = this.getCurrentDate();
        this.selectedDate = this.currentDate;

        this.selectedYear = this.getSelectedYear(this.selectedDate);
        this.getTrackingTravelGuides();
        this.getUsers();
        this.getCategories();
    },
    data() {
        return {
            tracking_travel_guides: [],
            paginate: 100,

            search: "",
            buffering: false,

            sort_direction: "desc",
            sort_field: "created_at",
            // general_remark_visibility: false,
            // general_remark: null,
            view_type: "master",
            selectedUser: "",
            selectedCategory: "",
            selectedResult: "",
            users: [],
            categories: [],
            errors: [],

            travel_guide_packages: [],

            wip_travel_guide: {
                id: "",
                tracking_tguide_id: "",
                wip_package_name: "",
                wip_package_date: "",
                wip_package_done: "",
                wip_package_user_id: "",
                wip_package_remark: "",
            },

            currentDate: "",

            selectedDate: "",
            selectedYear: "",
            isModalVisible: false,

            moment: moment,

            //month strings
            months: {
                Jan: "01",
                Feb: "02",
                Mac: "03",
                Apr: "04",
                May: "05",
                Jun: "06",
                Jul: "07",
                Aug: "08",
                Sep: "09",
                Oct: "10",
                Nov: "11",
                Dec: "12",
            },

            //export
            tguide_master_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Edition: "edition",
                Size: "tguide_size",
                Jan: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        // console.log('wip_tguide',wip_tguide);
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            //loop through the package
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    //return without bracket
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    //return with bracket
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                                // else {
                                //     new_arr.push(`-`)
                                // }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            //return empty
                            return ``;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            // return `${new_arr.join('-')}`
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
            },

            tguide_wip_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Edition: "edition",
                Size: "tguide_size",
                "A/W Reminder": {
                    callback: (value) => {
                        return !value.art_reminder_date
                            ? ``
                            : value.art_reminder_done === 2
                            ? `${this.showToday(value.art_reminder_date)}.`
                            : `(${this.showToday(value.art_reminder_date)})`;
                    },
                },
                "A/W Received": {
                    callback: (value) => {
                        return !value.art_record_date
                            ? ``
                            : value.art_record_done === 2 &&
                              value.art_record_date
                            ? `${this.showToday(value.art_record_date)}.`
                            : `(${this.showToday(value.art_record_date)})`;
                    },
                },

                Jan: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
            },

            summary_wip_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Edition: "edition",
                Size: "tguide_size",
                Jan: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                "Jan ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Feb ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Mac ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Apr ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "May ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Jun ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Jul ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Aug ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Sept ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Oct ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },

                "Nov ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12`
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else {
                                    new_arr.push(
                                        ` `
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                "Dec ": {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(``);
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(`✔`);
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
            },
        };
    },
    watch: {
        paginate: function (value) {
            this.getTrackingTravelGuides();
        },
        search: function (value) {
            this.getTrackingTravelGuides();
        },

        view_type: function (value) {
            this.getTrackingTravelGuides();
        },

        selectedUser: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },

        selectedCategory: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },

        selectedResult: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },

        selectedYear() {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },
    },

    methods: {
        exportExcel(type, fn, dl) {
            var elt = this.$refs.tguide_wip_table;
            var wb = XLSX.utils.table_to_book(elt, { sheet: "WIP" });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "WIPTravelGuide." + (type || "xlsx")
                  );
        },

        getTrackingTravelGuides(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/trackings/travel_guide/index?" +
                        "q=" +
                        this.search +
                        "&paginate=" +
                        this.paginate +
                        "&page=" +
                        page +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field +
                        "&view_type=" +
                        this.view_type +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedYear=" +
                        this.selectedYear
                    // +
                    // "&selectedCategory=" +
                    // this.selectedCategory +
                    // "&selectedResult=" +
                    // this.selectedResult
                )
                .then((res) => {
                    this.buffering = false;
                    this.tracking_travel_guides = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showModal(wip_travel_guide_id) {
            this.isModalVisible = true;
            this.getWIPTravelGuide(wip_travel_guide_id);
        },

        closeModal() {
            this.isModalVisible = false;
            this.getTrackingTravelGuides();
        },

        async getWIPTravelGuide(wip_travel_guide_id) {
            this.getUsers();
            this.getTravelGuidePackages();
            await axios
                .get("/api/trackings/wip/travel-guide/" + wip_travel_guide_id)
                .then((res) => {
                    this.wip_travel_guide = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async saveWIP(tracking_id) {
            if (window.confirm("Confirm update tracking ?"))
                try {
                    await axios
                        .post(
                            "/api/trackings/wip/travel-guide/update/" +
                                tracking_id,
                            {
                                wip_package_name:
                                    this.wip_travel_guide.wip_package_name,
                                wip_package_date:
                                    this.wip_travel_guide.wip_package_date,
                                wip_package_done:
                                    this.wip_travel_guide.wip_package_done,
                                wip_package_user_id:
                                    this.wip_travel_guide.wip_package_user_id,
                                wip_package_remark:
                                    this.wip_travel_guide.wip_package_remark,
                            }
                        )
                        .then((res) => {
                            this.closeModal();
                        });
                } catch (e) {
                    {
                        if (e.response.status === 422) {
                            this.errors = e.response.data.errors;
                        } else {
                            return "no error response";
                        }
                    }
                }
        },

        async getTravelGuidePackages() {
            await axios
                .get("/api/trackings/travel-guide/packages")
                .then((res) => {
                    this.travel_guide_packages = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategories() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getObjectKeyFromValue(obj, value) {
            return Object.keys(obj).find((key) => obj[key] === value);
        },

        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getTrackingTravelGuides();
        },

        deleteMasterGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/general/delete/" + id);
            this.getTrackingTravelGuides();
        },

        deleteWIPGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/wip/general/delete/" + id);
            this.getTrackingTravelGuides();
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },

        getMonth(date) {
            let day = moment(date).format("YYYY-MM");
            return day;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        checkMonth(wip_travel_guide, month_year) {
            var count = 0;
            // console.log(wip_travel_guide);
            for (let i = 0; i < wip_travel_guide.length; i++) {
                if (
                    this.getMonth(wip_travel_guide[i].wip_package_date) ===
                    month_year
                ) {
                    count++;
                }
            }
            return count > 0 ? true : false;
            // console.log(count > 0 ? true : false)
        },

        getDayMonth(date) {
            let day_month = moment(date).format("DD-MM");
            return day_month;
        },

        deleteTrackingTravelGuide(tracking_id) {
            if (
                !window.confirm(
                    "This will remove the tracking and its WIP(s). Continue?"
                )
            ) {
                return;
            }
            axios.delete("/api/trackings/travel_guide/delete/" + tracking_id);
            alert("Tracking and its WIP(s) deleted.");
            this.getTrackingTravelGuides();
        },

        exportMasterTravelGuidelExcel(type, fn, dl) {
            var elt = this.$refs.tguide_master_table;
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "Master Travel Guide",
            });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "Master Travel Guide." + (type || "xlsx")
                  );
        },

        exportWIPTravelGuideExcel(type, fn, dl) {
            var elt = this.$refs.tguide_wip_table;
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "WIP Travel Guide",
            });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "WIP Travel Guide." + (type || "xlsx")
                  );
        },

        check_id(contact_user_id) {
            let id = contact_user_id;
            // console.log(id)
            let user_id = parseInt(
                document
                    .querySelector('meta[name="user-id"]')
                    .getAttribute("content")
            );
            // console.log(user_id)
            if (id === user_id) {
                return true;
            } else {
                return false;
            }
        },

        async check_if_subordinate(contact_user_id) {
            let result = await axios
                .post("/api/users/check_subordinate", {
                    contact_user_id: contact_user_id,
                })
                .then((response) => {
                    return response.data.data;
                });
            console.log("result: ", result);

            if (result.id === 1) {
                // console.log("this is under the user")
                return "true";
            } else {
                // console.log("this is not under the user")
                return "false";
            }
        },
    },
};
</script>
