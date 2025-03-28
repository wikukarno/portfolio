import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextHeaderCard from '@/Components/TextHeaderCard';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useRef, useState } from 'react';

type CategoryProjectProps = {
    name: string;
    icon?: string;
    description?: string;
};

export default function Create({ name, description }: CategoryProjectProps) {
    const [showSuccess, setShowSuccess] = useState(false);
    const [previewIcon, setPreviewIcon] = useState<string | null>(null);
    const fileInputRef = useRef<HTMLInputElement>(null);

    const { data, setData, post, processing, errors } = useForm<{
        name: string;
        icon: File | string | null;
        description: string;
    }>({
        name: name ?? '',
        icon: null,
        description: description ?? '',
    });

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0] || null;

        if (file) {
            setData('icon', file);
            setPreviewIcon(URL.createObjectURL(file)); // 👈 create preview URL
        } else {
            setData('icon', null);
            setPreviewIcon(null);
        }
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        setShowSuccess(false);

        post(route('admin.category.project.store'), {
            onSuccess: () => {
                setShowSuccess(true);
                setPreviewIcon(null);

                setData({
                    name: '',
                    icon: null,
                    description: '',
                });

                if (fileInputRef.current) {
                    fileInputRef.current.value = '';
                }
            },
            onError: () => {
                setShowSuccess(false);
            },

            forceFormData: true,
        });
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Create Category Project
                </h2>
            }
        >
            <Head title="Create Category Project" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <TextHeaderCard
                                title="Add Category Project"
                                description="Create a new category project."
                            />

                            {showSuccess && (
                                <div className="mt-4 rounded bg-green-100 p-4 text-sm text-green-800">
                                    Data created successfully!
                                </div>
                            )}

                            {Object.keys(errors).length > 0 && (
                                <div className="mt-4 rounded bg-red-100 p-4 text-sm text-red-700">
                                    Please fix the errors below.
                                </div>
                            )}
                        </div>

                        <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <form
                                onSubmit={submit}
                                encType="multipart/form-data"
                            >
                                <div>
                                    <InputLabel htmlFor="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        name="name"
                                        className="mt-1 block w-full"
                                        placeholder="Category Project Name"
                                        value={data.name}
                                        onChange={(e) =>
                                            setData('name', e.target.value)
                                        }
                                        required
                                        isFocused
                                    />
                                    {errors.name && (
                                        <p className="mt-1 text-sm text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>

                                <div className="mt-4">
                                    <InputLabel htmlFor="icon" value="Icon" />

                                    {/* Preview Icon */}
                                    {previewIcon && (
                                        <img
                                            src={previewIcon}
                                            alt="Icon Preview"
                                            className="mb-2 h-12 w-12 rounded-md border object-contain"
                                        />
                                    )}

                                    <TextInput
                                        type="file"
                                        id="icon"
                                        name="icon"
                                        className="mt-1 block w-full rounded-md border-gray-300 p-2 ring-1 ring-gray-300"
                                        onChange={handleFileChange}
                                        ref={fileInputRef}
                                    />
                                    {errors.icon && (
                                        <p className="mt-1 text-sm text-red-600">
                                            {errors.icon}
                                        </p>
                                    )}
                                </div>

                                <div className="mt-4">
                                    <InputLabel
                                        htmlFor="description"
                                        value="Description"
                                    />
                                    <textarea
                                        id="description"
                                        name="description"
                                        className="mt-1 block w-full rounded-md border-gray-300 p-2 ring-gray-300"
                                        placeholder="Category Project Description"
                                        value={data.description}
                                        onChange={(e) =>
                                            setData(
                                                'description',
                                                e.target.value,
                                            )
                                        }
                                    ></textarea>
                                    {errors.description && (
                                        <p className="mt-1 text-sm text-red-600">
                                            {errors.description}
                                        </p>
                                    )}
                                </div>

                                <div className="mt-6 flex justify-end gap-4">
                                    <Link
                                        href={route(
                                            'admin.category.project.index',
                                        )}
                                    >
                                        <SecondaryButton type="button">
                                            Cancel
                                        </SecondaryButton>
                                    </Link>

                                    <PrimaryButton
                                        type="submit"
                                        disabled={processing}
                                    >
                                        {processing ? 'Saving...' : 'Save'}
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
