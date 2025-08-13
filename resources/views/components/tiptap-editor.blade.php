@props(['value'])

<div
    class="tiptap-wrapper border border-gray-300 dark:border-gray-700 rounded-lg"
    wire:ignore
    x-data="{
        value: @entangle($attributes->wire('model')),
        editor: null,

        init() {
            if (!window.Editor || !window.StarterKit || !window.Mathematics || !window.katex) {
                console.error('Tiptap editor or required extensions are not loaded!');
                return;
            }

            this.editor = new window.Editor({
                element: this.$refs.element,
                extensions: [
                    window.StarterKit,
                    window.Mathematics.configure({
                        // প্রয়োজনে এখানে অপশন যোগ করতে পারেন
                    }),
                ],
                content: this.value,
                onUpdate: ({ editor }) => {
                    this.value = editor.getHTML();
                },
            });

            // Livewire থেকে ডেটা পরিবর্তন হলে এডিটর আপডেট করবে
            this.$watch('value', (newValue) => {
                if (this.editor && this.editor.getHTML() !== newValue) {
                    this.editor.commands.setContent(newValue, false);
                }
            });
        },

        addMath() {
            Swal.fire({
                title: 'Enter LaTeX Code',
                input: 'text',
                inputPlaceholder: 'E = mc^2',
                showCancelButton: true,
                confirmButtonText: 'Insert',
                customClass: {
                    popup: '!bg-gray-800 !text-white',
                    title: '!text-white',
                    input: '!border-gray-600 !text-white'
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    this.editor.chain().focus().insertContent(`<span data-katex-inline>${result.value}</span>`).run();
                }
            });
        },
    }"
    x-init="init()"
>
    {{-- টুলবার --}}
    <div x-show="editor" class="toolbar p-2 border-b border-gray-300 dark:border-gray-700 flex flex-wrap items-center gap-2">
        <button
            type="button"
            @click="editor.chain().focus().toggleBold().run()"
            :class="{ 'bg-gray-600': editor?.isActive('bold') }"
            class="px-2 py-1 rounded hover:bg-gray-600">
            Bold
        </button>

        <button
            type="button"
            @click="editor.chain().focus().toggleItalic().run()"
            :class="{ 'bg-gray-600': editor?.isActive('italic') }"
            class="px-2 py-1 rounded hover:bg-gray-600">
            Italic
        </button>

        <button
            type="button"
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{ 'bg-gray-600': editor?.isActive('heading', {level: 2}) }"
            class="px-2 py-1 rounded hover:bg-gray-600">
            H2
        </button>

        <button
            type="button"
            @click="addMath()"
            class="px-2 py-1 rounded hover:bg-gray-600">
            ƒ(x) Math
        </button>
    </div>

    {{-- এডিটর --}}
    <div x-ref="element" class="prose dark:prose-invert max-w-none p-4 min-h-[150px]"></div>
</div>
