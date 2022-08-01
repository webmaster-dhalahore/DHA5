import React from "react";
import ReactDOM from "react-dom/client";

const CreateMember = () => {
    return <h1>Create Member From React updated</h1>;
};

export default CreateMember;

const container = document.getElementById("create-member");

if (container) {
    const root = ReactDOM.createRoot(container);
    root.render(
        <React.StrictMode>
            <CreateMember />
        </React.StrictMode>
    );
}
