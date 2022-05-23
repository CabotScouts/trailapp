import React from 'react';

export default function FormHeader({ title, children }) {
  return (
    <div className="mb-2">
      <h1 className="block mb-2 font-serif text-3xl text-purple-800">{ title }</h1>
      { children }
    </div>
  )
}
