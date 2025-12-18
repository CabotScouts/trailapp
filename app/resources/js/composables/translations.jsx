import { usePage } from '@inertiajs/react';
import reactStringReplace from 'react-string-replace';

export function __(value, attributes, array = usePage().props.translations) {
  const string = array[value] != null ? array[value] : value;
  const t = reactStringReplace(string, /(:[\w]+)/g, (m, _) => attributes[m.replace(":", "")] || m);
  console.log(t);
  return t;
}