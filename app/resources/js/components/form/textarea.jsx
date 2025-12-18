import React from 'react';

export default function Textarea(props) {
  return (
    <div>
      <label htmlFor="name" className="block font-medium text-sm text-slate-700">{props.title}</label>
      <div className="flex flex-col items-start">
        <textarea
          className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
          onChange={(e) => props.onChange(e)}
          {...props}
        />
      </div>
    </div>
  )
}
