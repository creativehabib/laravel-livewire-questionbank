@props(['value'])

<div
    class="tiptap-wrapper border border-gray-300 dark:border-gray-700 rounded-lg"
    wire:ignore
    x-data="{
        value: @entangle($attributes->wire('model')),
        editor: null,
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
                    // Insert inline math using TipTap's math extension
                    this.editor.chain().focus().insertInlineMath({ latex: result.value }).run();
                }
            });
        },
        init() {
            this.editor = new window.Editor({
                element: this.$refs.element,
                extensions: [
                    window.StarterKit,
                    window.Mathematics.configure({
                        inlineOptions: {
                            onClick: (node) => {
                                const newCalculation = prompt('Enter new calculation:', node.attrs.latex);
                                if (newCalculation) {
                                    this.editor.chain().setNodeSelection(node.pos).updateInlineMath({ latex: newCalculation }).focus().run();
                                }
                            }
                        }
                    }),
                ],
                content: this.value,
                onUpdate: ({ editor }) => {
                    this.value = editor.getHTML();
                },
            });

            this.$watch('value', (newValue) => {
                if (this.editor && this.editor.getHTML() !== newValue) {
                    this.editor.commands.setContent(newValue, false);
                }
            });
        },
        toggleBold() {
            // Delay to avoid mismatched transaction
            setTimeout(() => {
                if (this.editor) {
                    this.editor.chain().focus().toggleBold().run();
                }
            }, 0);
        },
        toggleItalic() {
            // Delay to avoid mismatched transaction
            setTimeout(() => {
                if (this.editor) {
                    this.editor.chain().focus().toggleItalic().run();
                }
            }, 0);
        }
    }"
>
    {{-- টুলবার --}}
    <div x-show="editor" class="toolbar p-2 border-b border-gray-300 dark:border-gray-700 flex flex-wrap items-center gap-2">
        <button
            type="button"
            @click="toggleBold()"
            :class="{ 'bg-gray-600': editor?.isActive('bold') }"
            class="px-2 py-1 rounded hover:bg-gray-600">
            Bold
        </button>

        <button
            type="button"
            @click="toggleItalic()"
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
    <div x-ref="element" class="prose dark:prose-invert max-w-none p-4 min-h-[150px]">{!! $value !!}</div>
</div>
