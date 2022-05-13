import React from 'react';

export default function ListFrame({ team, group, children }) {
  return (
    <div className="bg-neutral-100">
      <div className="px-5 py-4 bg-purple-900 shadow-sm">
        <p className="font-medium text-3xl font-serif text-neutral-50">{ team }</p>
        <p className="text-sm text-neutral-100">{ group }</p>
      </div>

      <div>
        { children }
      </div>
    </div>
  );
}

// <div className="flex-none p-5">
//   <p>Map/Challenges tabs</p>
// </div>
