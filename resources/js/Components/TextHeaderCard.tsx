export default function TextHeaderCard(props: {
    title: string;
    description: string;
}) {
    return (
        <>
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    {props.title}
                </h2>

                <p className="mt-1 text-sm text-gray-600">
                    {props.description}
                </p>
            </header>
        </>
    );
}
