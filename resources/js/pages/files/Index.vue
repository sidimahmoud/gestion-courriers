<script setup lang="ts">
import { ref, computed } from 'vue';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter, DialogTrigger } from '@/components/ui/dialog';
import { useForm } from '@inertiajs/vue3';
import { format } from 'date-fns';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

defineProps<{
  files: {
    id: number | string;
    object: string;
    type?: string;
    status?: string;
    destination_id?: number | string | null;
    created_at: string;
    category?: { name?: string } | null;
  }[];
  search?: string;
}>();

const search = ref('');
const showModal = ref(false);
const form = useForm<{ object: string; file: File | null }>({ object: '', file: null });

const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: 'Files',
    href: '/files',
  },
];

function handleFileChange(event: Event) {
  const target = event.target as HTMLInputElement;
  form.file = target.files ? target.files[0] : null;
}

function submit() {
  form.post(route('files.store'), {
    forceFormData: true,
    onSuccess: () => {
      form.reset();
      showModal.value = false;
    },
  });
}
</script>

<template>
  <Head title="Files" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <!-- Search and Add Form Card -->
      <Card>
        <CardHeader>
          <CardTitle>Files</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="flex items-center gap-2 mb-4">
            <Input v-model="search" placeholder="Search files..." class="flex-1" />
            <Dialog v-model:open="showModal">
              <DialogTrigger as-child>
                <Button>Add New File</Button>
              </DialogTrigger>
              <DialogContent>
                <DialogHeader>
                  <DialogTitle>Add New File</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submit" class="space-y-4">
                  <Input v-model="form.object" placeholder="File name" :disabled="form.processing" required />
                  <Input type="file" @change="handleFileChange" :disabled="form.processing" required />
                  <DialogFooter>
                    <Button type="submit" :disabled="form.processing">Create</Button>
                  </DialogFooter>
                </form>
              </DialogContent>
            </Dialog>
          </div>
        </CardContent>
      </Card>

      <!-- File List Card -->
      <Card>
        <CardHeader>
          <CardTitle>File List</CardTitle>
        </CardHeader>
        <CardContent>
          <div v-if="files.length === 0" class="text-center text-gray-400 py-8">
            No files found.
          </div>
          <div v-else class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left font-semibold">Name</th>
                  <th class="px-4 py-2 text-left font-semibold">Type</th>
                  <th class="px-4 py-2 text-left font-semibold">Status</th>
                  <th class="px-4 py-2 text-left font-semibold">Destination</th>
                  <th class="px-4 py-2 text-left font-semibold">Category</th>
                  <th class="px-4 py-2 text-left font-semibold">Created At</th>
                  <th class="px-4 py-2 text-left font-semibold">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="file in files" :key="file.id" class="hover:bg-gray-50 transition">
                  <td class="px-4 py-2 font-medium">{{ file.object }}</td>
                  <td class="px-4 py-2">{{ file.type }}</td>
                  <td class="px-4 py-2">{{ file.status }}</td>
                  <td class="px-4 py-2">{{ file.destination_id ?? '-' }}</td>
                  <td class="px-4 py-2">{{ file.category?.name ?? '-' }}</td>
                  <td class="px-4 py-2 text-xs text-gray-400">{{ format(new Date(file.created_at), 'PPpp') }}</td>
                  <td class="px-4 py-2">
                    <Button as="a" :href="route('files.show', file.id)" target="_blank" variant="outline" size="sm">
                      Show
                    </Button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Add any custom styles for modern look here */
</style> 