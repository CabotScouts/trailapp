import React from 'react';
import { __ } from '@/composables/translations';

export default function Errors({ errors }) {
  return (
    Object.keys(errors).length > 0 && (
      <div className="mb-4">
        <div className="font-medium text-red-600">{__("Whoops! Something went wrong.")}</div>

        <ul className="mt-3 list-disc list-inside text-sm text-red-600">
          {Object.keys(errors).map(function (key, index) {
            return <li key={index}>{errors[key]}</li>;
          })}
        </ul>
      </div>
    )
  );
}
