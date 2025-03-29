import ConfirmationModal from '@/Components/ConfirmationModal';
import TextHeaderCard from '@/Components/TextHeaderCard';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Edit3, Trash2 } from 'lucide-react';
import { useEffect, useState } from 'react';

type Project = {
    id: string;
    title: string;
};

type PaginatedCategory = {
    data: Project[];
    current_page: number;
    last_page: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
};

type FlashProps = {
    flash: {
        success?: string;
    };
    errors: Record<string, string>;
};

export default function Index() {
    const { props } = usePage<
        PageProps & FlashProps & { projects: PaginatedCategory }
    >();
    const projects = props.projects;

    const [confirmingId, setConfirmingId] = useState<string | null>(null);

    const [showFlash, setShowFlash] = useState(true);

    useEffect(() => {
        if (props.flash?.success || props.errors?.error) {
            setShowFlash(true);
            const timer = setTimeout(() => {
                setShowFlash(false);
            }, 4000);

            return () => clearTimeout(timer);
        }
    }, [props.flash, props.errors]);

    const handleConfirmDelete = (id: string) => {
        setConfirmingId(id);
    };

    const handleCancelDelete = () => {
        setConfirmingId(null);
    };

    const handleDelete = () => {
        if (confirmingId) {
            router.delete(route('admin.project.destroy', confirmingId), {
                onSuccess: () => setConfirmingId(null),
            });
        }
    };

    const decodeEntities = (html: string) => {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    };

    return (
        <>
            <AuthenticatedLayout
                header={
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Projects
                    </h2>
                }
            >
                <Head title="Projects" />

                <div className="py-12">
                    <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div className="overflow-hidden rounded-lg bg-white shadow-sm">
                            {showFlash && props.flash?.success && (
                                <div className="mb-4 flex items-start justify-between rounded bg-green-100 px-4 py-2 text-sm text-green-700">
                                    <span>{props.flash.success}</span>
                                    <button
                                        onClick={() => setShowFlash(false)}
                                        className="ml-4 text-green-700 hover:text-green-900"
                                    >
                                        &times;
                                    </button>
                                </div>
                            )}

                            {showFlash && props.errors?.error && (
                                <div className="mb-4 flex items-start justify-between rounded bg-red-100 px-4 py-2 text-sm text-red-700">
                                    <span>{props.errors.error}</span>
                                    <button
                                        onClick={() => setShowFlash(false)}
                                        className="ml-4 text-red-700 hover:text-red-900"
                                    >
                                        &times;
                                    </button>
                                </div>
                            )}

                            <div className="flex items-center justify-between border-b p-6">
                                <TextHeaderCard
                                    title="Category Project"
                                    description="List of project projects"
                                />

                                <Link
                                    href={route('admin.project.create')}
                                    className="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                >
                                    + Create
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Id
                                            </th>
                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Title
                                            </th>
                                            <th className="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-100 bg-white">
                                        {projects.data.length > 0 ? (
                                            projects.data.map((project) => (
                                                <tr key={project.id}>
                                                    <td className="px-6 py-4 text-sm text-gray-900">
                                                        {project.id}
                                                    </td>
                                                    <td className="px-6 py-4 text-sm text-gray-900">
                                                        {project.title}
                                                    </td>
                                                    <td className="px-6 py-4 text-right">
                                                        <div className="flex justify-end gap-2">
                                                            <Link
                                                                href={route(
                                                                    'admin.project.edit',
                                                                    project.id,
                                                                )}
                                                                className="inline-flex items-center gap-1 rounded px-2 py-1 text-sm text-blue-600 hover:underline"
                                                            >
                                                                <Edit3 className="h-4 w-4" />
                                                                Edit
                                                            </Link>

                                                            <button
                                                                onClick={() =>
                                                                    handleConfirmDelete(
                                                                        project.id,
                                                                    )
                                                                }
                                                                className="inline-flex items-center gap-1 rounded px-2 py-1 text-sm text-red-600 hover:underline"
                                                            >
                                                                <Trash2 className="h-4 w-4" />
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td
                                                    colSpan={4}
                                                    className="px-6 py-4 text-center text-sm text-gray-500"
                                                >
                                                    No project projects found.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>

                            {/* Pagination */}
                            <div className="flex justify-center border-t px-4 py-3">
                                <div className="inline-flex flex-wrap gap-1">
                                    {projects.links.map((link, index) => (
                                        <Link
                                            key={index}
                                            href={link.url ?? '#'}
                                            className={`rounded border px-3 py-1 text-sm ${
                                                link.active
                                                    ? 'border-blue-600 bg-blue-600 text-white'
                                                    : !link.url
                                                      ? 'cursor-not-allowed border-gray-300 text-gray-400'
                                                      : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                                            }`}
                                        >
                                            {decodeEntities(link.label)}
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>

            <ConfirmationModal
                isOpen={!!confirmingId}
                onClose={handleCancelDelete}
                onConfirm={handleDelete}
                message="Are you sure you want to delete this data?"
            />
        </>
    );
}
