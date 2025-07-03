<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const page = usePage();
const fileStats = page.props.fileStats as {
    completed: number;
    in_progress: number;
    arrival: number;
    departure: number;
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex items-center justify-center">
                    <div>
                        <div class="text-3xl font-bold text-center">{{ fileStats.completed }}</div>
                        <div class="text-center text-lg mt-2">Files Completed</div>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex items-center justify-center">
                    <div>
                        <div class="text-3xl font-bold text-center">{{ fileStats.in_progress }}</div>
                        <div class="text-center text-lg mt-2">Files In Progress</div>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex items-center justify-center">
                    <div>
                        <div class="text-3xl font-bold text-center">{{ fileStats.arrival }}</div>
                        <div class="text-center text-lg mt-2">Arrival Files</div>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex items-center justify-center">
                    <div>
                        <div class="text-3xl font-bold text-center">{{ fileStats.departure }}</div>
                        <div class="text-center text-lg mt-2">Departure Files</div>
                    </div>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border flex items-center justify-center">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
