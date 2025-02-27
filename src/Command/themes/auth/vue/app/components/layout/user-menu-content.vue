<script setup>
import { Link } from '@inertiajs/vue3';
import { LogOut, Settings } from 'lucide-vue-next';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/shared/avatar';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/shared/dropdown-menu';
import { getInitials } from '@/utils';

defineProps({
    showEmail: {
        type: Boolean,
        default: true,
    },
    user: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
                <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" />
                <AvatarFallback class="rounded-lg text-black dark:text-white">
                    {{ getInitials(user.name) }}
                </AvatarFallback>
            </Avatar>

            <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-medium">{{ user.name }}</span>
                <span class="truncate text-xs text-muted-foreground" v-if="showEmail">{{ user.email }}</span>
            </div>
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" href="/settings/profile" as="button">
            <Settings class="mr-2 h-4 w-4" />
            Settings
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" href="/auth/logout" as="button">
        <LogOut class="mr-2 h-4 w-4" />
        Log out
        </Link>
    </DropdownMenuItem>
</template>
