import React from 'react';

export default function Frame(props) {
  return (
    <div className="min-h-screen max-h-screen flex flex-col bg-neutral-100">
      <div className="flex-none p-5 bg-purple-900 shadow-sm">
        <p className="font-medium text-2xl font-serif text-neutral-50">{ props.team }</p>
      </div>

      <div className="flex-grow overflow-auto">
        { props.children }
      </div>
    </div>
  );
}

// <div className="flex-none p-5">
//   <p>Map/Challenges tabs</p>
// </div>
