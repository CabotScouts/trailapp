import React from 'react';

export default function Frame({ team, group, children }) {
  return (
    <div className="flex flex-col bg-neutral-100">
      <div className="flex-none px-5 py-4 bg-purple-900 shadow-sm">
        <p className="font-medium text-3xl font-serif text-neutral-50">{ team }</p>
        <p className="text-sm text-neutral-100">{ group }</p>
      </div>

      <div className="flex-grow overflow-auto scroll-region">
        { children }
      </div>
    </div>
  );
}

// <div className="flex-none p-5">
//   <p>Map/Challenges tabs</p>
// </div>
