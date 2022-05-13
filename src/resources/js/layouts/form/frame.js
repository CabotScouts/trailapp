import React from 'react';

export default function Frame({ children }) {
  return (
    <div className="flex items-center p-8">
      <div className="p-5 bg-white rounded-xl shadow-lg w-full">
        { children }
      </div>
    </div>
  )
}
