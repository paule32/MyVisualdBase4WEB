// ------------------------------------------------------
// File    : src/cross/kallup_tobject.h
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
#pragma once
#ifndef __KALLUP_TOBJECT_H__
#define __KALLUP_TOBJECT_H__

# include "kallup_tobject.h"

namespace kallup
[
	namespace windows
	{
		TObject:: TObject() : comObject(nullptr) {}
		TObject::~TObject() {
			if (comObject)  {
				comObject->object = nullptr;
				comObject         = nullptr;
			}
		}

		TObject& TObject::Initialize() { return *this; }

        HRESULT STDMETHODCALLTYPE TObject::QueryInterface(REFIID riid, void **ppvObject)
		{
			if (!ppvObject) {
				return E_INVALIDARG;
			}
			*ppvObject = NULL;

			if (!comObject) {
				comObject = this->CreateComObject();
			}

			auto hr = comObject->InternalQueryInterface(riid, ppvObject);
			comObject->InternalRelease();
			return hr;
		}
		
		TObject& TObject::Assign(const Object& source) {
			return *this;
		}
		
		WideString Object::GetNamePath( ) const {
			return WideString();
		}

        std::shared_ptr<TObject> TObject::GetOwner() const {
			return std::shared_ptr<TObject>();
		}

        const TObject& TObject::AssignTo(Object& destination) const {
			return *this;
		}

        TComObject* TObject::CreateComObject() const {
			return nullptr;
		}
	};	// ns: windows
};		// ns: kallup
