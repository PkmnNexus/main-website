<nav
    class="mb-4 flex items-center gap-2 text-sm text-gray-500"
>
    <template
        x-for="(crumb, index) in breadcrumb()"
        :key="crumb.id ?? 'root'"
    >

        <div class="flex items-center gap-2">

            <button
                type="button"
                class="transition hover:text-primary-600"
                @click="selectedFolderId = crumb.id"
                x-text="crumb.name"
            ></button>

            <span
                x-show="index < breadcrumb().length - 1"
            >
                /
            </span>

        </div>

    </template>
</nav>