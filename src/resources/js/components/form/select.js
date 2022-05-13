import React from 'react';

export default function SelectInput({ title, name, onChange, required, placeholder, children }) {
  return (
    <div>
      <label htmlFor="group" className="block font-medium text-sm text-slate-700">{ title }</label>
      <div className="flex flex-col items-start">
        <select
          name={ name }
          className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
          required={ required }
          defaultValue="-"
          onChange={(e) => onChange(e)}
        >
          <option key="-" value="-" disabled>{ placeholder }</option>
          { children }
        </select>
      </div>
    </div>
  )
}
