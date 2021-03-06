import React from 'react';

export default function Textarea({ title, type, name, onChange, required, placeholder, value }) {
  return (
    <div>
      <label htmlFor="name" className="block font-medium text-sm text-slate-700">{ title }</label>
      <div className="flex flex-col items-start">
        <textarea
          type={ type }
          name={ name }
          value={ value }
          className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
          required={ required }
          placeholder={ placeholder }
          onChange={(e) => onChange(e)}
        />
      </div>
    </div>
  )
}
