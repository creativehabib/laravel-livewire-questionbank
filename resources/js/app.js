import Swal from 'sweetalert2';
import TomSelect from "tom-select";

// Tiptap এবং এর এক্সটেনশনগুলো ইম্পোর্ট করুন
import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Mathematics from '@tiptap/extension-mathematics'

// AlpineJS এবং অন্যান্য পেজ থেকে ব্যবহারের জন্য এগুলোকে window অবজেক্টে যোগ করুন
window.Swal = Swal;
window.TomSelect = TomSelect;
window.Editor = Editor;
window.StarterKit = StarterKit;
window.Mathematics = Mathematics;

// সাধারণ alert-এর জন্য গ্লোবাল লিসেনার
window.addEventListener('swal:alert', event => {
    let detail = event.detail[0] || event.detail; // Handle both syntaxes
    Swal.fire({
        title: detail.title,
        text: detail.text,
        icon: detail.type,
        timer: detail.timer,
        showConfirmButton: detail.showConfirmButton,
        timerProgressBar: detail.timer !== null, // টাইমার থাকলে პროგრეს বার দেখাবে
    });
});

// কনফার্মেশন ডায়ালগের জন্য গ্লোবাল লিসেনার
window.addEventListener('swal:confirm', event => {
    let detail = event.detail[0] || event.detail; // Handle both syntaxes
    Swal.fire({
        title: detail.title,
        text: detail.text,
        icon: detail.type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, নিশ্চিত!',
        cancelButtonText: 'না, বাতিল করুন'
    }).then((result) => {
        if (result.isConfirmed) {
            // নির্দিষ্ট Livewire মেথডকে কল করবে
            Livewire.dispatch(detail.method, { params: detail.params });
        }
    });
});

